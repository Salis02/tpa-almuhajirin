<?php

namespace App\Http\Controllers;

use App\Models\StudentReport;
use App\Models\Santri;
use App\Models\AssessmentCategory;
use App\Models\Assessment;
use App\Models\TpaClass;
use App\Models\StudentReportDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentReport::with(['santri.tpaClass', 'creator']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        // Filter by period type
        if ($request->filled('period_type')) {
            $query->where('period_type', $request->period_type);
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(12);
        $classes = TpaClass::where('is_active', true)->get();
        $academicYears = StudentReport::distinct()->pluck('academic_year')->sort()->values();

        return view('report.index', compact('reports', 'classes', 'academicYears'));
    }

    public function create()
    {
        $santris = Santri::with('tpaClass')->where('status', 'active')->get();
        $assessmentCategories = AssessmentCategory::with('activeAssessments')->where('is_active', true)->get();
        
        return view('report.create', compact('santris', 'assessmentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'period_type' => 'required|in:monthly,semester,yearly',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'academic_year' => 'required|string|max:10',
            'teacher_notes' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'assessments' => 'required|array',
            'assessments.*' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Create main report
            $report = StudentReport::create([
                'santri_id' => $validated['santri_id'],
                'period_type' => $validated['period_type'],
                'period_start' => $validated['period_start'],
                'period_end' => $validated['period_end'],
                'academic_year' => $validated['academic_year'],
                'teacher_notes' => $validated['teacher_notes'],
                'recommendations' => $validated['recommendations'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            // Save assessment details
            foreach ($validated['assessments'] as $assessmentId => $scoreValue) {
                $assessment = Assessment::findOrFail($assessmentId);
                $numericScore = $this->convertToNumericScore($assessment, $scoreValue);

                StudentReportDetail::create([
                    'student_report_id' => $report->id,
                    'assessment_id' => $assessmentId,
                    'score_value' => $scoreValue,
                    'numeric_score' => $numericScore,
                    'notes' => $request->input("notes.{$assessmentId}"),
                ]);
            }

            // Calculate and save overall score
            $report->overall_score = $report->calculateOverallScore();
            $report->summary_scores = $this->calculateSummaryScores($report);
            $report->save();

            DB::commit();

            return redirect()->route('report.index')
                           ->with('success', 'Laporan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(StudentReport $report)
    {
        $report->load(['santri.tpaClass', 'reportDetails.assessment.assessmentCategory', 'creator']);
        return view('report.show', compact('report'));
    }

    public function edit(StudentReport $report)
    {
        $report->load(['reportDetails']);
        $assessmentCategories = AssessmentCategory::with('activeAssessments')->where('is_active', true)->get();
        
        return view('report.edit', compact('report', 'assessmentCategories'));
    }

    public function update(Request $request, StudentReport $report)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'academic_year' => 'required|string|max:10',
            'teacher_notes' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'assessments' => 'required|array',
            'assessments.*' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Update main report
            $report->update([
                'period_start' => $validated['period_start'],
                'period_end' => $validated['period_end'],
                'academic_year' => $validated['academic_year'],
                'teacher_notes' => $validated['teacher_notes'],
                'recommendations' => $validated['recommendations'],
                'status' => $validated['status'],
                'published_at' => $validated['status'] === 'published' ? now() : $report->published_at,
            ]);

            // Update assessment details
            $report->reportDetails()->delete();
            
            foreach ($validated['assessments'] as $assessmentId => $scoreValue) {
                $assessment = Assessment::findOrFail($assessmentId);
                $numericScore = $this->convertToNumericScore($assessment, $scoreValue);

                StudentReportDetail::create([
                    'student_report_id' => $report->id,
                    'assessment_id' => $assessmentId,
                    'score_value' => $scoreValue,
                    'numeric_score' => $numericScore,
                    'notes' => $request->input("notes.{$assessmentId}"),
                ]);
            }

            // Recalculate scores
            $report->overall_score = $report->calculateOverallScore();
            $report->summary_scores = $this->calculateSummaryScores($report);
            $report->save();

            DB::commit();

            return redirect()->route('report.index')
                           ->with('success', 'Laporan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(StudentReport $report)
    {
        try {
            $report->delete();
            return redirect()->route('report.index')
                           ->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function publish(StudentReport $report)
    {
        $report->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->back()
                       ->with('success', 'Laporan berhasil dipublikasikan.');
    }

    private function convertToNumericScore($assessment, $scoreValue)
    {
        switch ($assessment->assessment_type) {
            case 'numeric':
                return (float) $scoreValue;
            
            case 'grade':
                $gradeMapping = ['A' => 100, 'B' => 80, 'C' => 60, 'D' => 40];
                return $gradeMapping[$scoreValue] ?? 0;
            
            case 'boolean':
                return $scoreValue === 'true' || $scoreValue === '1' ? 100 : 0;
            
            default:
                return 0;
        }
    }

    private function calculateSummaryScores($report)
    {
        $categories = AssessmentCategory::where('is_active', true)->get();
        $summary = [];

        foreach ($categories as $category) {
            $summary[$category->name] = [
                'score' => $report->getCategoryScore($category),
                'weight' => $category->weight,
                'display_name' => $category->display_name,
            ];
        }

        return $summary;
    }
    public function preview(StudentReport $report)
    {
        $report->load(['santri.tpaClass', 'reportDetails.assessment.assessmentCategory', 'creator']);

        return view('report.pdf', compact('report'));
    }

    public function exportPdf(StudentReport $report)
    {
        $report->load(['santri.tpaClass', 'reportDetails.assessment.assessmentCategory', 'creator']);

        $pdf = Pdf::loadView('report.pdf', compact('report'))
                ->setPaper('A4', 'portrait');

        return $pdf->download("Raport-{$report->santri->name}.pdf");
    }
}