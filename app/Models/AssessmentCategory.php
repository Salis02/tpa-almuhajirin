<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'icon',
        'color',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function activeAssessments()
    {
        return $this->hasMany(Assessment::class)->where('is_active', true);
    }
}