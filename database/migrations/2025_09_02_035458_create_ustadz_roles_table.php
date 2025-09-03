<?php

use App\Models\Ustadz;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ustadz_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ustadz_id')->constrained('ustadz')->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['ustadz_id', 'role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ustadz_roles');
    }
};