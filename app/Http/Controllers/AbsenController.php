<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsenController extends Controller
{
    public function index()
    {
        return view('absensi.index');
    }

    public function store(Request $request)
    {
        // VALIDASI SESUAI VIEW
        $data = $request->validate([
            'name'   => 'required|string',
            'date'   => 'required|date',
            'status' => 'required|string',
        ]);

        // URL Apps Script
        $webhookUrl = config('services.gsheet.webhook_url');

        // Payload SESUAI Apps Script
        $response = Http::post($webhookUrl, [
            'name'   => $data['name'],
            'date'   => $data['date'],
            'status' => $data['status'],
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Absen berhasil disimpan.');
        }

        return back()->with('error', 'Gagal menyimpan absen.');
    }
}
