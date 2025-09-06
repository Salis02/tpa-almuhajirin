<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // akademik, akhlak
            $table->string('display_name'); // Akademik, Akhlak
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // untuk UI
            $table->string('color')->default('#3B82F6'); // hex color
            $table->integer('weight')->default(50); // bobot penilaian (%)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_categories');
    }
};