<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('step_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->text('notes')->nullable();
            $table->unsignedInteger('order')->default(0);

            $table->string('status')->default('not_started'); // not_started, in_progress, completed, skipped
            $table->string('priority')->default('medium');    // low, medium, high
            $table->unsignedTinyInteger('progress')->default(0); // 0–100 (used only if task has subtasks)

            $table->date('target_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};