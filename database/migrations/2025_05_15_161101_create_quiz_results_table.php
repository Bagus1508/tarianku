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
    Schema::create('quiz_results', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->foreignId('quiz_question_id')->constrained()->onDelete('cascade');
        $table->string('selected_option')->nullable();
        $table->boolean('is_correct')->default(false);
        $table->integer('time_taken')->default(0);
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
