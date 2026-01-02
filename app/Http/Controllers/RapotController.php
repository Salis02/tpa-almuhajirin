<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TpaClass;
use App\Models\Santri;

class RapotController extends Controller
{
    public function index(Request $request)
    {
        try {
            $url = config('services.gsheet.raport.webhook');
            $response = Http::timeout(15)->get($url);

            if (!$response->successful()) {
                return view('rapot.index', ['raports' => collect(), 'classes' => TpaClass::all(), 'santris' => Santri::all()])
                    ->with('error', 'Gagal sinkron dengan Google Sheet.');
            }

            $raports = collect($response->json());
            // dd($raports);
            // 🔍 Filter: Search (nama_santri / nis)
            if ($request->filled('search')) {
                $search = strtolower($request->search);

                $raports = $raports->filter(function ($item) use ($search) {
                    return str_contains(strtolower($item['nama_santri'] ?? ''), $search)
                        || str_contains(strtolower($item['nis'] ?? ''), $search);
                });
            }

            // 🏫 Filter: Kelas
            if ($request->filled('kelas')) {
                $kelas = strtolower($request->kelas);
                $raports = $raports->filter(
                    fn($item) =>
                    strtolower($item['kelas'] ?? '') === $kelas
                );
            }

            // 📘 Filter: Status Raport (Sesuaikan dengan value "Draft" atau "Final")
            if ($request->filled('status')) {
                $status = strtolower($request->status); // misal user pilih 'draft'
                $raports = $raports->filter(
                    fn($item) =>
                    strtolower($item['status_raport'] ?? '') === $status
                );
            }

            return view('rapot.index', [
                'raports' => $raports->values(), // values() untuk me-reset index array setelah difilter
                'classes' => TpaClass::orderBy('display_name')->get(),
                'santris' => Santri::all()
            ]);
        } catch (\Throwable $e) {
            return view('rapot.index', ['raports' => collect()])->with('error', 'Koneksi bermasalah.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required',
            'kelas' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nilai' => 'required|array',
            'nilai' => 'required|array',
            'materi' => 'nullable',
            'catatan' => 'nullable',
            'status_rapot' => 'required',
        ]);

        $santri = Santri::find($request->santri_id);
        $ustadz = auth()->user()->name ?? 'Ustadzah';

        // Bungkus dalam payload sesuai variabel di Apps Script Raport
        $payload = [
            'tahun_ajaran' => $validated['tahun_ajaran'],
            'semester' => $validated['semester'],
            'nis' => $santri->nis,
            'nama_santri' => $santri->full_name,
            'kelas' => $validated['kelas'],
            'ustadz' => $ustadz,
            'nilai' => $validated['nilai'],
            'nilai' => $validated['nilai'],
            'materi' => $validated['materi'],
            'catatan' => $validated['catatan'],
            'status_raport' => $validated['status_rapot'],
        ];

        // dd($payload);
        $response = Http::post(config('services.gsheet.raport.webhook'), $payload);

        if ($response->successful()) {
            return back()->with('success', 'Data Raport berhasil dikirim ke Google Sheet');
        }

        return back()->with('error', 'Gagal kirim ke GSheet: ' . $response->status());
    }

    public function update(Request $request)
    {
        $response = Http::post(config('services.gsheet.raport.webhook'), [
            'action' => 'UPDATE',
            'timestamp' => $request->timestamp,
            'nis' => $request->nis,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'kelas' => $request->kelas,
            'nama_santri' => $request->nama_santri,
            'ustadz' => $request->ustadz,
            'nilai' => $request->nilai,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'status_raport' => $request->status_raport
        ]);

        if ($response->json('success')) {
            return back()->with('success', 'Raport berhasil diperbarui');
        }
        return back()->with('error', 'Gagal update: ' . $response->json('error'));
    }
    public function exportPdf(Request $request)
    {
        $url = config('services.gsheet.raport.webhook');
        $response = Http::get($url);
        $raports = collect($response->json());

        $data = $raports->where('nis', $request->nis)
            ->where('semester', $request->semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->first();

        if (!$data) return back()->with('error', 'Data raport tidak ditemukan');

        $pdf = Pdf::loadView('rapot.pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Raport_{$data['nama_santri']}_{$data['semester']}.pdf");
    }
}
