<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'period_type',
        'period_start',
        'period_end',
        'academic_year',
        'summary_scores',
        'overall_score',
        'teacher_notes',
        'recommendations',
        'status',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'summary_scores' => 'array',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reportDetails()
    {
        return $this->hasMany(StudentReportDetail::class);
    }

    // Helpers
    public function getPeriodLabelAttribute()
    {
        return $this->period_start->format('M Y') . ' - ' . $this->period_end->format('M Y');
    }

    public function calculateOverallScore()
    {
        $categories = AssessmentCategory::where('is_active', true)->get();
        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($categories as $category) {
            $categoryScore = $this->getCategoryScore($category);
            if ($categoryScore !== null) {
                $totalWeightedScore += $categoryScore * $category->weight;
                $totalWeight += $category->weight;
            }
        }

        return $totalWeight > 0 ? round($totalWeightedScore / $totalWeight, 2) : null;
    }

    public function getCategoryScore($category)
    {
        $assessments = $category->activeAssessments;
        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($assessments as $assessment) {
            $detail = $this->reportDetails()->where('assessment_id', $assessment->id)->first();
            if ($detail && $detail->numeric_score !== null) {
                $totalWeightedScore += $detail->numeric_score * $assessment->weight;
                $totalWeight += $assessment->weight;
            }
        }

        return $totalWeight > 0 ? round($totalWeightedScore / $totalWeight, 2) : null;
    }
}