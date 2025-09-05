<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedule_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            
            $table->enum('status', ['registered', 'present', 'absent', 'late'])->default('registered');
            $table->text('notes')->nullable(); // catatan progress santri
            $table->timestamps();
            
            $table->unique(['schedule_id', 'santri_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_participants');
    }
};