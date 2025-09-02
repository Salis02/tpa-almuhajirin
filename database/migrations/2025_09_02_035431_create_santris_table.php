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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // Nomor Induk Santri
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->enum('gender', ['L', 'P']); // Laki-laki, Perempuan
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('photo_path')->nullable();
            
            // Data Orang Tua/Wali
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('guardian_name')->nullable(); // Jika diasuh wali
            $table->string('guardian_phone');
            $table->text('guardian_address')->nullable();
            
            // Data Kelas
            $table->foreignId('class_id')->constrained('classes');
            $table->date('enrollment_date');
            $table->enum('status', ['active', 'inactive', 'graduated', 'dropped'])->default('active');

            $table->timestamps();

            $table->index(['class_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
