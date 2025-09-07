<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_reports', function (Blueprint $table) {
            $table->json('summary_scores')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('student_reports', function (Blueprint $table) {
            $table->json('summary_scores')->nullable(false)->change();
        });
    }
};
