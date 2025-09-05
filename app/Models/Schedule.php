<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'schedule_type_id',
        'ustadz_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'max_participants',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relationships
    public function tpaClass()
    {
        return $this->belongsTo(TpaClass::class, 'class_id');
    }

    public function scheduleType()
    {
        return $this->belongsTo(ScheduleType::class);
    }

    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class);
    }

    public function participants()
    {
        return $this->hasMany(ScheduleParticipant::class);
    }

    public function santris()
    {
        return $this->belongsToMany(Santri::class, 'schedule_participants')
                    ->withPivot(['status', 'notes'])
                    ->withTimestamps();
    }

    // Accessors
    public function getParticipantCountAttribute()
    {
        return $this->participants()->count();
    }

    public function getAvailableSlotsAttribute()
    {
        $max = $this->max_participants ?: $this->scheduleType->max_participants;
        return $max - $this->participant_count;
    }

    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', today());
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('schedule_type_id', $typeId);
    }
}