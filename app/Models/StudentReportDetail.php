<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentReportDetail extends Model
{
    protected $fillable = [
        'student_report_id',
        'assessment_id',
        'score_value',
        'numeric_score',
        'notes',
    ];

    // Relasi balik
    public function report()
    {
        return $this->belongsTo(StudentReport::class, 'student_report_id');
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
