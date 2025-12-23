<?php

namespace App\Http\Controllers;

use App\Models\TpaRaport;
use App\Models\TpaSubject;
use App\Services\TpaRaportService;
use Illuminate\Http\Request;

class TpaRaportController extends Controller
{
    protected TpaRaportService $raportService;

    public function __construct(TpaRaportService $raportService)
    {
        $this->raportService = $raportService;
    }

    /**
     * GET /raports
     * List raport
     */
    public function index()
    {
        $raports = TpaRaport::with(['santri', 'ustadz'])
            ->latest()
            ->paginate(15);

        return view('raports.index', compact('raports'));
    }

    /**
     * GET /raports/create
     * Form input raport
     */
    public function create()
    {
        $subjects = TpaSubject::where('is_active', true)
            ->orderBy('order_index')
            ->get();

        return view('raports.create', compact('subjects'));
    }

    /**
     * POST /raports
     * Simpan raport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id'    => 'required|exists:santris,id',
            'ustadz_id'    => 'required|exists:ustadz,id',
            'semester'     => 'required|string',
            'tahun_ajaran' => 'required|string',

            'scores'                 => 'required|array',
            'scores.*.nilai'         => 'required|integer|min:1|max:100',
            'scores.*.keterangan'    => 'nullable|string',

            'catatan_pengajar' => 'nullable|string',
        ]);

        $raport = $this->raportService->createRaport($validated);

        return redirect()
            ->route('raports.show', $raport)
            ->with('success', 'Raport berhasil disimpan');
    }

    /**
     * GET /raports/{raport}
     * Lihat raport
     */
    public function show(TpaRaport $raport)
    {
        $raport->load(['santri', 'ustadz', 'scores.subject']);

        $average = $this->raportService->calculateAverage($raport);

        return view('raports.show', compact('raport', 'average'));
    }

    /**
     * GET /raports/{raport}/edit
     * (Opsional) Form edit raport
     */
    public function edit(TpaRaport $raport)
    {
        // Nanti kalau diperlukan
        abort(404);
    }

    /**
     * PUT /raports/{raport}
     */
    public function update(Request $request, TpaRaport $raport)
    {
        // Nanti kalau diperlukan
        abort(404);
    }
}
