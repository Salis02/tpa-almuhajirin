<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
                'raports' => $raports->values(), // reset key
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
        // 1️⃣ Validasi sesuai payload Apps Script
        $data = $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',

            'nis' => 'required|string',
            'nama_santri' => 'required|string',
            'kelas' => 'required|string',
            'ustadz' => 'required|string',

            'nilai.tahsin' => 'required|integer|min:1|max:100',
            'nilai.khot' => 'required|integer|min:1|max:100',
            'nilai.hafalan' => 'required|integer|min:1|max:100',
            'nilai.praktek_sholat' => 'required|integer|min:1|max:100',
            'nilai.praktek_wudhu' => 'required|integer|min:1|max:100',
            'nilai.aqidah' => 'required|integer|min:1|max:100',
            'nilai.doa_harian' => 'required|integer|min:1|max:100',
            'nilai.ayat_pilihan' => 'required|integer|min:1|max:100',
            'nilai.qiroah' => 'required|integer|min:1|max:100',
            'nilai.tajwid' => 'required|integer|min:1|max:100',

            'materi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status_raport' => 'nullable|string',
        ]);

        // 2️⃣ Kirim ke Google Sheets
        $response = Http::post(
            config('services.gsheet.raport.webhook'),
            $data
        );

        // 3️⃣ Handle response
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Raport berhasil dikirim',
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim raport',
            'error' => $response->body(),
        ], 500);
    }
}
