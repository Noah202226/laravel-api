<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubtaskFactory extends Factory
{
    // Chunk any task into small, actionable bites
    private static array $subtaskSets = [
        'Watch PHP for Beginners on Laracasts' => [
            'Set up local dev environment (Herd or Valet)',
            'Watch episodes 1–5: variables and types',
            'Watch episodes 6–10: arrays and loops',
            'Watch episodes 11–15: functions and scope',
            'Take notes and summarize key concepts',
        ],
        'Create a model and use Eloquent CRUD' => [
            'Generate model with php artisan make:model',
            'Use ::create() to insert a record',
            'Retrieve records with ::all() and ::find()',
            'Update a record using ->update()',
            'Delete a record using ->delete()',
        ],
        'Build a small practice project' => [
            'Define the project requirements',
            'Set up the routes and controllers',
            'Build the database schema and migrate',
            'Implement the core feature',
            'Review code and add basic tests',
        ],
        'Write your first migration' => [
            'Run php artisan make:migration',
            'Add columns to the up() method',
            'Run php artisan migrate',
            'Verify table in DB with Tinker',
            'Write the rollback in down()',
        ],
        'Install Laravel Breeze' => [
            'Run composer require laravel/breeze',
            'Run php artisan breeze:install',
            'Run npm install && npm run dev',
            'Test login and register flows',
            'Customize the auth views to match app style',
        ],
        // Generic fallback
        'default' => [
            'Read the relevant documentation',
            'Watch a tutorial or course section',
            'Write the code following along',
            'Test the implementation',
            'Refactor and clean up',
        ],
    ];

    public function definition(): array
    {
        $subtasks = $this->faker->randomElement(array_values(self::$subtaskSets));
        $title = $this->faker->randomElement($subtasks);

        return [
            'task_id' => Task::factory(),
            'title' => $title,
            'is_completed' => false,
            'order' => 0,
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'is_completed' => true,
            'completed_at' => now()->subDays(rand(1, 10)),
        ]);
    }

    /**
     * Get subtasks for a specific task title, falling back to default.
     */
    public static function subtasksFor(string $taskTitle): array
    {
        return self::$subtaskSets[$taskTitle] ?? self::$subtaskSets['default'];
    }
}