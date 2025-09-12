<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul dokumen
            $table->string('file_path'); // Lokasi file yang diupload
            $table->string('category')->nullable(); // kategori dokumen (opsional)
            $table->text('description')->nullable(); // deskripsi
            $table->unsignedBigInteger('uploaded_by')->nullable(); // user yang upload
            $table->timestamps();

            // relasi ke users
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
