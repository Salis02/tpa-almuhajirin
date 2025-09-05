<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'santri_id',
        'status',
        'notes',
    ];

    // Relationships
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}