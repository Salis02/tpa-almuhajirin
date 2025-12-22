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
        Schema::create('tpa_raports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('santri_id');
            $table->unsignedBigInteger('ustadz_id');

            $table->string('semester');
            $table->string('tahun_ajaran', 9);

            $table->text('catatan_ustadz')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                [
                    'santri_id',
                    'semester',
                    'tahun_ajaran'
                ],
                'tpa_raports_unique_per_semester'
            );

            $table->foreign('ustadz_id')
                ->references('id')
                ->on('user')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpa_raports');
    }
};
