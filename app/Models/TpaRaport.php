<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TpaRaport extends Model
{
    use SoftDeletes;

    protected $table = 'tpa_raports';

    protected $fillable = [
        'santri_id',
        'ustadz_id',
        'semester',
        'tahun_ajaran',
        'catatan_pengajar',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Raport milik satu santri
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    // Raport dibuat oleh satu ustadz
    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class);
    }

    // Raport memiliki banyak nilai
    public function scores()
    {
        return $this->hasMany(TpaRaportScore::class, 'tpa_raport_id');
    }

    // Shortcut: ambil nilai + subject
    public function scoresWithSubject()
    {
        return $this->scores()->with('subject');
    }
}
