<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->string('score_value'); // nilai (bisa angka, huruf, atau boolean)
            $table->decimal('numeric_score', 5, 2)->nullable(); // konversi ke angka untuk perhitungan
            $table->text('notes')->nullable(); // catatan spesifik
            $table->json('progress_data')->nullable(); // data progress dari kegiatan
            $table->timestamps();
            
            $table->unique(['student_report_id', 'assessment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_report_details');
    }
};