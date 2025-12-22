<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaRaportScore extends Model
{
    protected $table = 'tpa_raport_scores';

    protected $fillable = [
        'tpa_raport_id',
        'tpa_subject_id',
        'nilai',
        'keterangan',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function raport()
    {
        return $this->belongsTo(TpaRaport::class, 'tpa_raport_id');
    }

    public function subject()
    {
        return $this->belongsTo(TpaSubject::class, 'tpa_subject_id');
    }
}
