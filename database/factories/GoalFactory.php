<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    private static array $goals = [
        [
            'title' => 'Become a Professional Laravel Developer',
            'description' => 'Master Laravel from the ground up — from basics to building production-ready APIs and full-stack apps.',
            'category' => 'Career',
            'purpose' => 'I want to build my own products and work remotely as a full-time developer.',
            'goal_for' => 'For my future self and my family — to give them a better life.',
            'dream_outcome' => 'Landing my first dev job or first paying client, working from home, and being proud of the code I write.',
            'fear_of_not_doing' => 'Staying in a job I hate, watching others build the life I want while I do nothing.',
            'motivation_quote' => 'Every expert was once a beginner. Start before you are ready.',
            'reward' => 'Buy a mechanical keyboard and celebrate with a nice dinner.',
            'reward_type' => 'item',
            'cover_emoji' => '🚀',
            'cover_color' => '#6C63FF',
            'category_tag' => 'Backend',
        ],
        [
            'title' => 'Master Frontend with Vue & Inertia',
            'description' => 'Learn Vue 3 and Inertia.js to build beautiful, reactive UIs on top of Laravel.',
            'category' => 'Career',
            'purpose' => 'To build full-stack apps without needing a separate frontend developer.',
            'goal_for' => 'For myself — to become a complete developer.',
            'dream_outcome' => 'Shipping a polished full-stack SaaS app that people actually love using.',
            'fear_of_not_doing' => 'Always being dependent on others for the frontend side of projects.',
            'motivation_quote' => 'The best way to learn is to build something real.',
            'reward' => 'A weekend trip to somewhere new.',
            'reward_type' => 'experience',
            'cover_emoji' => '🎨',
            'cover_color' => '#10B981',
            'category_tag' => 'Frontend',
        ],
        [
            'title' => 'Launch My First SaaS MVP',
            'description' => 'Take an idea from concept to a live, paying product.',
            'category' => 'Business',
            'purpose' => 'To prove to myself I can ship something real and generate income from code.',
            'goal_for' => 'For financial freedom and creative independence.',
            'dream_outcome' => 'Getting my first paying customer and seeing $1 in MRR.',
            'fear_of_not_doing' => 'Spending years learning but never shipping — all theory, no impact.',
            'motivation_quote' => 'Done is better than perfect.',
            'reward' => 'New laptop upgrade.',
            'reward_type' => 'item',
            'cover_emoji' => '💡',
            'cover_color' => '#F59E0B',
            'category_tag' => 'Product',
        ],
    ];

    public function definition(): array
    {
        $goal = $this->faker->randomElement(self::$goals);

        return [
            'user_id' => User::factory(),
            'title' => $goal['title'],
            'description' => $goal['description'],
            'category' => $goal['category'],
            'purpose' => $goal['purpose'],
            'goal_for' => $goal['goal_for'],
            'dream_outcome' => $goal['dream_outcome'],
            'fear_of_not_doing' => $goal['fear_of_not_doing'],
            'motivation_quote' => $goal['motivation_quote'],
            'reward' => $goal['reward'],
            'reward_type' => $goal['reward_type'],
            'reward_claimed' => false,
            'status' => 'in_progress',
            'progress' => 0,
            'priority' => $this->faker->randomElement(['medium', 'high']),
            'is_pinned' => false,
            'is_public' => false,
            'cover_emoji' => $goal['cover_emoji'],
            'cover_color' => $goal['cover_color'],
            'start_date' => now()->subDays(rand(1, 14)),
            'target_date' => now()->addMonths(rand(3, 12)),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'progress' => 100,
            'reward_claimed' => true,
            'completed_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    public function pinned(): static
    {
        return $this->state(fn() => ['is_pinned' => true]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn() => ['user_id' => $user->id]);
    }
}