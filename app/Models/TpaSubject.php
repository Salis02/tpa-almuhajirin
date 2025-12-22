<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaSubject extends Model
{
    protected $table = 'tpa_subjects';

    protected $fillable = [
        'name',
        'category',
        'order_index',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function raportScores()
    {
        return $this->hasMany(TpaRaportScore::class, 'tpa_subject_id');
    }
}
