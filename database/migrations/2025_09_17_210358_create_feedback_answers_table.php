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
       Schema::create('feedback_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('feedback_questions')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp');
            $table->text('answer_text')->nullable(); 
            $table->foreignId('option_id')->nullable()->constrained('feedback_options')->cascadeOnDelete(); 
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_answers');
    }
};
