<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Santri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'full_name',
        'nickname',
        'gender',
        'birth_date',
        'birth_place',
        'address',
        'phone',
        'photo_path',
        'father_name',
        'mother_name',
        'guardian_name',
        'guardian_phone',
        'guardian_address',
        'class_id',
        'enrollment_date',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    // Relationships
    public function tpaClass()
    {
        return $this->belongsTo(TpaClass::class, 'class_id');
    }

    public function raports()
    {
        return $this->hasMany(TpaRaport::class);
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->birth_date->age;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return Storage::url($this->photo_path);
        }
        
        // Default avatar berdasarkan gender
        return $this->gender === 'L' 
            ? asset('images/default-male-avatar.png')
            : asset('images/default-female-avatar.png');
    }

    public function getDisplayNameAttribute()
    {
        return $this->nickname ?: $this->full_name;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }
}
