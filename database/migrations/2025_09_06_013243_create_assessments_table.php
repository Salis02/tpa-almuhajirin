<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_category_id')->constrained()->onDelete('cascade');
            $table->string('name'); // tajwid, hafalan, sholat, dll
            $table->string('display_name'); // Tajwid, Hafalan Al-Quran, Sholat
            $table->text('description')->nullable();
            $table->enum('assessment_type', ['numeric', 'grade', 'boolean']); // angka, huruf, ya/tidak
            $table->json('scale_config'); // konfigurasi skala penilaian
            $table->integer('weight')->default(10); // bobot dalam kategori
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};