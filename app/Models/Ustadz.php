<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ustadz extends Model
{
    use HasFactory;

    protected $table = 'ustadz';

    protected $fillable = [
        'user_id',
        'nip',
        'full_name',
        'gender',
        'birth_date',
        'birth_place',
        'address',
        'phone',
        'email',
        'photo_path',
        'education_level',
        'education_major',
        'certification',
        'join_date',
        'employment_status',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'ustadz_roles');
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

        return $this->gender === 'L'
            ? asset('images/default-male-avatar.png')
            : asset('images/default-female-avatar.png');
    }

    public function getYearsOfServiceAttribute()
    {
        return $this->join_date->diffInYears(now());
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeByEmploymentStatus($query, $status)
    {
        return $query->where('employment_status', $status);
    }
}
