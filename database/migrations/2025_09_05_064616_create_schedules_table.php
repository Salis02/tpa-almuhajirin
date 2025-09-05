<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('schedule_type_id')->constrained('schedule_types');
            $table->foreignId('ustadz_id')->constrained('ustadz');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location')->nullable(); // ruang/tempat
            
            $table->integer('max_participants')->nullable(); // override dari schedule_type
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            
            $table->text('notes')->nullable(); // catatan khusus
            $table->timestamps();
            
            $table->index(['date', 'start_time']);
            $table->index(['class_id', 'schedule_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};