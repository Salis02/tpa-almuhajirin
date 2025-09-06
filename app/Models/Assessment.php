<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_category_id',
        'name',
        'display_name',
        'description',
        'assessment_type',
        'scale_config',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'scale_config' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function assessmentCategory()
    {
        return $this->belongsTo(AssessmentCategory::class);
    }

    public function reportDetails()
    {
        return $this->hasMany(StudentReportDetail::class);
    }

    // Helpers
    public function getScaleOptionsAttribute()
    {
        $config = $this->scale_config ?? [];
        
        switch ($this->assessment_type) {
            case 'numeric':
                return [
                    'min' => $config['min'] ?? 0,
                    'max' => $config['max'] ?? 100,
                    'step' => $config['step'] ?? 1,
                ];
            case 'grade':
                return $config['grades'] ?? ['A', 'B', 'C', 'D'];
            case 'boolean':
                return $config['labels'] ?? ['Baik', 'Perlu Perbaikan'];
            default:
                return [];
        }
    }
}