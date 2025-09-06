<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->string('period_type'); // monthly, semester, yearly
            $table->date('period_start');
            $table->date('period_end');
            $table->string('academic_year', 10); // 2024/2025
            $table->json('summary_scores'); // ringkasan nilai per kategori
            $table->decimal('overall_score', 5, 2)->nullable(); // nilai keseluruhan
            $table->text('teacher_notes')->nullable(); // catatan ustadz
            $table->text('recommendations')->nullable(); // rekomendasi
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['santri_id', 'period_type', 'academic_year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_reports');
    }
};