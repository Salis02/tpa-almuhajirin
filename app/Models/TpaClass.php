<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TpaClass extends Model
{
    use HasFactory;

    protected $table = 'classes';
    
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function santris()
    {
        return $this->hasMany(Santri::class, 'class_id');
    }

    public function activeSantris()
    {
        return $this->hasMany(Santri::class, 'class_id')->where('status', 'active');
    }

    // Accessors
    public function getCurrentCapacityAttribute()
    {
        return $this->activeSantris()->count();
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->capacity - $this->current_capacity;
    }
}
