<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('description')->nullable();
            $table->longText('answer')->nullable();
            $table->foreignId('semester_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
