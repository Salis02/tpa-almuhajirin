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
        'start_time' => 'string', // fix dari datetime
        'end_time'   => 'string', // fix dari datetime
    ];

    // Accessors untuk Carbon
    public function getStartTimeCarbonAttribute()
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time);
    }

    public function getEndTimeCarbonAttribute()
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time);
    }

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
        $max = $this->max_participants ?? optional($this->scheduleType)->max_participants ?? 0;
        return $max - $this->participant_count;
    }

    public function getDurationAttribute()
    {
        return $this->start_time_carbon->diffInMinutes($this->end_time_carbon);
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

    // Scope untuk check conflict
    public function scopeConflict($query, $ustadzId, $date, $start, $end, $ignoreId = null)
    {
        return $query->where('ustadz_id', $ustadzId)
                     ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                     ->where('date', $date)
                     ->where(function ($q) use ($start, $end) {
                         $q->whereBetween('start_time', [$start, $end])
                           ->orWhereBetween('end_time', [$start, $end])
                           ->orWhere(function ($sub) use ($start, $end) {
                               $sub->where('start_time', '<=', $start)
                                   ->where('end_time', '>=', $end);
                           });
                     })
                     ->where('status', '!=', 'cancelled');
    }
}
