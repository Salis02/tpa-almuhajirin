<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ustadz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip')->unique(); // Nomor Induk Pegawai
            $table->string('full_name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('photo_path')->nullable();
            
            // Data Akademik
            $table->enum('education_level', ['SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->string('education_major')->nullable();
            $table->string('certification')->nullable(); // Sertifikat mengajar
            
            // Data Kepegawaian
            $table->date('join_date');
            $table->enum('employment_status', ['tetap', 'honorer', 'magang'])->default('honorer');
            $table->enum('status', ['active', 'inactive', 'resign'])->default('active');
            
            $table->timestamps();
            
            $table->index(['status', 'employment_status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ustadz');
    }
};