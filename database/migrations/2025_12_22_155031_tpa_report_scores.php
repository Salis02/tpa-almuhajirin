<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tpa_raport_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tpa_raport_id');
            $table->unsignedBigInteger('tpa_subject_id');

            $table->unsignedTinyInteger('nilai'); // 1 - 100
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // UNIQUE per raport + subject
            $table->unique(
                ['tpa_raport_id', 'tpa_subject_id'],
                'tpa_raport_scores_unique'
            );

            // Foreign Keys
            $table->foreign('tpa_raport_id')
                ->references('id')
                ->on('tpa_raports')
                ->onDelete('cascade');

            $table->foreign('tpa_subject_id')
                ->references('id')
                ->on('tpa_subjects')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpa_raport_scores');
    }
};
