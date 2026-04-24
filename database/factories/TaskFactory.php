<?php

namespace Database\Factories;

use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    private static array $taskSets = [
        // PHP Foundations
        'PHP Foundations' => [
            'Watch PHP for Beginners on Laracasts',
            'Understand variables, arrays, and loops',
            'Learn OOP: classes, interfaces, and traits',
            'Practice with a simple CLI task manager',
            'Understand namespaces and autoloading (Composer)',
        ],
        // Laravel Basics
        'Laravel Basics' => [
            'Install Laravel via Composer',
            'Understand the MVC pattern in Laravel',
            'Create routes and basic controllers',
            'Build Blade templates and layouts',
            'Use middleware for route protection',
        ],
        // Database & Eloquent
        'Database & Eloquent ORM' => [
            'Write your first migration',
            'Create a model and use Eloquent CRUD',
            'Define hasMany and belongsTo relationships',
            'Use query scopes and eager loading',
            'Seed the database with factories',
        ],
        // Auth
        'Authentication & Security' => [
            'Install Laravel Breeze',
            'Understand session vs token auth',
            'Set up Sanctum for API tokens',
            'Write a policy and gate for authorization',
            'Hash passwords and protect routes',
        ],
        // API Dev
        'API Development' => [
            'Create a RESTful resource controller',
            'Build API resources and collections',
            'Handle validation with Form Requests',
            'Version the API with route prefixes',
            'Add rate limiting to API routes',
        ],
        // Testing
        'Testing' => [
            'Write a feature test for registration',
            'Test CRUD endpoints with HTTP assertions',
            'Mock external services in unit tests',
            'Use Pest for cleaner test syntax',
            'Run tests in CI with GitHub Actions',
        ],
        // Deployment
        'Deployment' => [
            'Push project to GitHub',
            'Connect repo to Laravel Cloud',
            'Set environment variables in the dashboard',
            'Run migrations via the Commands tab',
            'Set up queue workers and scheduled tasks',
        ],
        // Generic fallback
        'default' => [
            'Research and take notes',
            'Follow along with a tutorial',
            'Build a small practice project',
            'Review and refactor the code',
            'Write a short summary of what you learned',
        ],
    ];

    public function definition(): array
    {
        $tasks = $this->faker->randomElement(array_values(self::$taskSets));
        $title = $this->faker->randomElement($tasks);

        return [
            'step_id' => Step::factory(),
            'title' => $title,
            'notes' => $this->faker->optional(0.4)->sentence(),
            'order' => 0,
            'status' => 'not_started',
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'progress' => 0,
            'target_date' => now()->addDays(rand(3, 21)),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now()->subDays(rand(1, 14)),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn() => [
            'status' => 'in_progress',
            'progress' => rand(10, 90),
        ]);
    }

    /**
     * Get tasks for a specific step title, falling back to default.
     */
    public static function tasksFor(string $stepTitle): array
    {
        return self::$taskSets[$stepTitle] ?? self::$taskSets['default'];
    }
}