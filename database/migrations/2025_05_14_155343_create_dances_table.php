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
        Schema::create('dances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('origin_region')->nullable();
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
            $table->boolean('is_archived')->nullable();
            $table->tinyInteger('difficulty_level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dances');
    }
};
