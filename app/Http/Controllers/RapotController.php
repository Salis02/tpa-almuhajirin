<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TpaClass;
use App\Models\Santri;

class RapotController extends Controller
{
    public function index(Request $request)
    {
        try {
            $url = config('services.gsheet.raport.webhook');

            if (! $url) {
                abort(500, 'GSHEET_RAPORT_WEBHOOK belum diset');
            }

            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                return back()->with('error', 'Gagal mengambil data raport dari Google Sheet');
            }

            // Pastikan data array
            $raports = collect($response->json());
            $classes = TpaClass::orderBy('display_name')->get();
            $santri = Santri::all();

            /**
             * Expected structure per item:
             * [
             *   'nis' => '',
             *   'nama' => '',
             *   'kelas' => '',
             *   'materi' => '',
             *   'status_raport' => ''
             * ]
             */

            // 🔍 Filter: Search (nama / nis)
            if ($request->filled('search')) {
                $search = strtolower($request->search);

                $raports = $raports->filter(function ($item) use ($search) {
                    return str_contains(strtolower($item['nama'] ?? ''), $search)
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

            // 📘 Filter: Status Raport
            if ($request->filled('status')) {
                $status = strtolower($request->status);

                $raports = $raports->filter(
                    fn($item) =>
                    strtolower($item['status_raport'] ?? '') === $status
                );
            }

            return view('rapot.index', [
                'raports' => $raports->values(),
                'classes' => $classes,
                'santris' => $santri
            ]);
        } catch (\Throwable $e) {
            report($e);

            return view('rapot.index', [
                'raports' => collect(),
            ])->with('error', 'Terjadi kesalahan saat memuat data raport');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required',
            'kelas' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nilai' => 'required|array', // Ini menangkap nilai[tahsin], nilai[khot], dll
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
            'nilai' => $validated['nilai'], // Ini akan jadi objek {tahsin: 80, khot: 90, ...}
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
}
