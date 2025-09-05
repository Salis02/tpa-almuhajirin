<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedule_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // setoran, praktek, privat
            $table->string('display_name'); // Setoran, Praktek, Privat
            $table->text('description')->nullable();
            $table->integer('max_participants')->default(30);
            $table->integer('duration_minutes')->default(60); // durasi dalam menit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_types');
    }
};