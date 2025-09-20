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
        Schema::table('feedback_questions', function (Blueprint $table) {
            // Perbaiki typo: multiple_choise -> multiple_choice
            $table->enum('type', ['free_text', 'multiple_choice', 'rating'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_questions', function (Blueprint $table) {
            // Rollback ke typo sebelumnya jika diperlukan
            $table->enum('type', ['free_text', 'multiple_choise', 'rating'])->change();
        });
    }
};