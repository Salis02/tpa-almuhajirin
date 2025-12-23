<?php

namespace App\Services;

use App\Models\TpaRaport;
use App\Models\TpaRaportScore;
use Illuminate\Support\Facades\DB;

class TpaRaportService
{
    public function createRaport(array $data): TpaRaport
    {
        return DB::transaction(function () use ($data) {
            $raport = TpaRaport::create([
                'santri_id' => $data['santri_id'],
                'ustadz_id'        => $data['ustadz_id'],
                'semester'         => $data['semester'],
                'tahun_ajaran'     => $data['tahun_ajaran'],
                'catatan_pengajar' => $data['catatan_pengajar'] ?? null,
            ]);

            foreach ($data['scores'] as $subjectId => $nilai) {
                TpaRaportScore::create([
                    'tpa_raport_id'  => $raport->id,
                    'tpa_subject_id' => $subjectId,
                    'nilai'          => $nilai['nilai'],
                    'keterangan'     => $nilai['keterangan'] ?? null,
                ]);
            }

            return $raport;
        });
    }

    public function calculateAverage(TpaRaport $raport): float
    {
        return round(
            $raport->scores()->avg('nilai'),
            2
        );
    }
}
