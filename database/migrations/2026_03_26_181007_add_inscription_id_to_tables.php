<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('paiment', function (Blueprint $table) {
            $table->foreignId('inscription_id')->constrained('inscriptions')->cascadeOnDelete();
        });

        Schema::table('absences', function (Blueprint $table) {
            $table->foreignId('inscription_id')->constrained('inscriptions')->cascadeOnDelete();
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->foreignId('inscription_id')->constrained('inscriptions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
