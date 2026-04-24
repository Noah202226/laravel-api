<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    // Realistic Laravel dev roadmap steps
    private static array $stepSets = [
        // Goal: Become a Professional Laravel Developer
        'laravel' => [
            ['title' => 'PHP Foundations', 'description' => 'Understand PHP syntax, OOP, and how the web works.'],
            ['title' => 'Laravel Basics', 'description' => 'Routing, controllers, views, Blade, and middleware.'],
            ['title' => 'Database & Eloquent ORM', 'description' => 'Migrations, models, relationships, and query builder.'],
            ['title' => 'Authentication & Security', 'description' => 'Laravel Breeze/Sanctum, hashing, policies, and gates.'],
            ['title' => 'API Development', 'description' => 'RESTful APIs, API resources, versioning, and rate limiting.'],
            ['title' => 'Testing', 'description' => 'Feature tests, unit tests with PHPUnit and Pest.'],
            ['title' => 'Deployment', 'description' => 'Deploy to Laravel Cloud, queues, caching, and monitoring.'],
        ],
        // Goal: Master Frontend with Vue & Inertia
        'vue' => [
            ['title' => 'JavaScript Essentials', 'description' => 'ES6+, async/await, fetch, and DOM basics.'],
            ['title' => 'Vue 3 Fundamentals', 'description' => 'Components, reactivity, props, emits, and Composition API.'],
            ['title' => 'Inertia.js Integration', 'description' => 'Connect Laravel backend with Vue frontend via Inertia.'],
            ['title' => 'Tailwind CSS', 'description' => 'Utility-first CSS, responsive design, and dark mode.'],
            ['title' => 'State Management', 'description' => 'Pinia for global state across components.'],
            ['title' => 'Build & Optimize', 'description' => 'Vite setup, code splitting, and performance tips.'],
        ],
        // Goal: Launch First SaaS MVP
        'saas' => [
            ['title' => 'Idea Validation', 'description' => 'Define the problem, target user, and core value prop.'],
            ['title' => 'Tech Stack Setup', 'description' => 'Set up Laravel, Inertia, Tailwind, and CI/CD pipeline.'],
            ['title' => 'Core Feature Build', 'description' => 'Build the one feature that delivers the main value.'],
            ['title' => 'Auth & Billing', 'description' => 'User accounts, subscriptions with Stripe/Cashier.'],
            ['title' => 'Landing Page', 'description' => 'Clear hero, features, pricing, and call-to-action.'],
            ['title' => 'Beta Launch', 'description' => 'Get 10 beta users, collect feedback, iterate.'],
            ['title' => 'Public Launch', 'description' => 'ProductHunt, Twitter, and niche communities.'],
        ],
    ];

    public function definition(): array
    {
        $sets = array_values(self::$stepSets);
        $steps = $this->faker->randomElement($sets);
        $step = $this->faker->randomElement($steps);

        return [
            'goal_id' => Goal::factory(),
            'title' => $step['title'],
            'description' => $step['description'],
            'order' => 0, // set explicitly in seeder
            'status' => 'not_started',
            'progress' => 0,
            'start_date' => null,
            'target_date' => now()->addWeeks(rand(2, 8)),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now()->subDays(rand(1, 20)),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn() => [
            'status' => 'in_progress',
            'progress' => rand(10, 80),
        ]);
    }

    /**
     * Return ordered step data for a specific goal type.
     */
    public static function stepsFor(string $goalType): array
    {
        return self::$stepSets[$goalType] ?? self::$stepSets['laravel'];
    }
}