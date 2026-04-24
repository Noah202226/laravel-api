<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();

            // --- Core ---
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // e.g. Career, Finance, Health

            // --- Motivation & Purpose ---
            $table->text('purpose')->nullable();         // Why does this goal matter to you?
            $table->text('goal_for')->nullable();        // Who are you doing this for? (yourself, family, etc.)
            $table->text('dream_outcome')->nullable();   // What does success look like?
            $table->text('fear_of_not_doing')->nullable(); // What happens if you don't do this?
            $table->string('motivation_quote')->nullable(); // A personal quote or mantra

            // --- Reward System ---
            $table->string('reward')->nullable();          // What will you reward yourself with?
            $table->string('reward_type')->nullable();     // e.g. experience, item, rest, treat
            $table->boolean('reward_claimed')->default(false);

            // --- Progress & Status ---
            $table->string('status')->default('not_started'); // not_started, in_progress, completed, paused, abandoned
            $table->unsignedTinyInteger('progress')->default(0); // 0–100, auto-computed from steps

            // --- Priority & Visibility ---
            $table->string('priority')->default('medium'); // low, medium, high
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_public')->default(false);

            // --- Cover / Mood ---
            $table->string('cover_emoji')->nullable();   // e.g. 🚀
            $table->string('cover_color')->nullable();   // e.g. #6C63FF (for card background)

            // --- Dates ---
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};