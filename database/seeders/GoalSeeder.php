<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\Step;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Database\Factories\StepFactory;
use Database\Factories\TaskFactory;
use Database\Factories\SubtaskFactory;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Full developer roadmap seed data.
     *
     * Structure:
     *   User → Goals → Steps → Tasks → Subtasks
     *
     * Progress bubbles up automatically via model methods.
     */
    public function run(): void
    {
        // ── Create (or reuse) the demo user ──────────────────────────
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Noah',
                'password' => bcrypt('password'),
            ]
        );

        // ── Seed the three main goals ────────────────────────────────
        $this->seedLaravelGoal($user);
        $this->seedVueGoal($user);
        $this->seedSaasGoal($user);
    }

    // ── Goal 1: Become a Professional Laravel Developer ──────────────

    private function seedLaravelGoal(User $user): void
    {
        $goal = Goal::create([
            'user_id' => $user->id,
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
            'reward_claimed' => false,
            'status' => 'in_progress',
            'progress' => 0,
            'priority' => 'high',
            'is_pinned' => true,
            'cover_emoji' => '🚀',
            'cover_color' => '#6C63FF',
            'start_date' => now()->subWeeks(2),
            'target_date' => now()->addMonths(6),
        ]);

        $steps = StepFactory::stepsFor('laravel');

        foreach ($steps as $index => $stepData) {
            $step = Step::create([
                'goal_id' => $goal->id,
                'title' => $stepData['title'],
                'description' => $stepData['description'],
                'order' => $index + 1,
                'status' => $index === 0 ? 'completed' : ($index === 1 ? 'in_progress' : 'not_started'),
                'progress' => 0,
                'target_date' => now()->addWeeks(($index + 1) * 3),
            ]);

            $taskTitles = TaskFactory::tasksFor($stepData['title']);

            foreach ($taskTitles as $taskIndex => $taskTitle) {
                // Step 1 (index 0): all completed
                // Step 2 (index 1): first 2 completed, rest not started
                // Others: not started
                $isCompleted = $index === 0
                    || ($index === 1 && $taskIndex < 2);

                $task = Task::create([
                    'step_id' => $step->id,
                    'title' => $taskTitle,
                    'order' => $taskIndex + 1,
                    'status' => $isCompleted ? 'completed' : 'not_started',
                    'priority' => $taskIndex === 0 ? 'high' : 'medium',
                    'progress' => 0,
                    'target_date' => now()->addDays(($taskIndex + 1) * 4),
                    'completed_at' => $isCompleted ? now()->subDays(rand(1, 10)) : null,
                ]);

                // Add subtasks to the first task of step 1 and step 2
                if ($index <= 1 && $taskIndex === 0) {
                    $subtaskTitles = SubtaskFactory::subtasksFor($taskTitle);

                    foreach ($subtaskTitles as $subIndex => $subtaskTitle) {
                        Subtask::create([
                            'task_id' => $task->id,
                            'title' => $subtaskTitle,
                            'order' => $subIndex + 1,
                            'is_completed' => $isCompleted || $subIndex < 2,
                            'completed_at' => ($isCompleted || $subIndex < 2) ? now()->subDays(rand(1, 5)) : null,
                        ]);
                    }
                }
            }
        }

        // Bubble up progress from the bottom
        $this->recomputeAll($goal);
    }

    // ── Goal 2: Master Frontend with Vue & Inertia ───────────────────

    private function seedVueGoal(User $user): void
    {
        $goal = Goal::create([
            'user_id' => $user->id,
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
            'reward_claimed' => false,
            'status' => 'not_started',
            'progress' => 0,
            'priority' => 'medium',
            'is_pinned' => false,
            'cover_emoji' => '🎨',
            'cover_color' => '#10B981',
            'start_date' => now()->addMonths(6),
            'target_date' => now()->addMonths(10),
        ]);

        $steps = StepFactory::stepsFor('vue');

        foreach ($steps as $index => $stepData) {
            $step = Step::create([
                'goal_id' => $goal->id,
                'title' => $stepData['title'],
                'description' => $stepData['description'],
                'order' => $index + 1,
                'status' => 'not_started',
                'progress' => 0,
                'target_date' => now()->addMonths(6)->addWeeks(($index + 1) * 2),
            ]);

            $taskTitles = TaskFactory::tasksFor($stepData['title']);

            foreach ($taskTitles as $taskIndex => $taskTitle) {
                Task::create([
                    'step_id' => $step->id,
                    'title' => $taskTitle,
                    'order' => $taskIndex + 1,
                    'status' => 'not_started',
                    'priority' => 'medium',
                    'progress' => 0,
                    'target_date' => now()->addMonths(6)->addDays(($taskIndex + 1) * 5),
                ]);
            }
        }
    }

    // ── Goal 3: Launch First SaaS MVP ────────────────────────────────

    private function seedSaasGoal(User $user): void
    {
        $goal = Goal::create([
            'user_id' => $user->id,
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
            'reward_claimed' => false,
            'status' => 'not_started',
            'progress' => 0,
            'priority' => 'high',
            'is_pinned' => false,
            'cover_emoji' => '💡',
            'cover_color' => '#F59E0B',
            'start_date' => now()->addMonths(10),
            'target_date' => now()->addMonths(14),
        ]);

        $steps = StepFactory::stepsFor('saas');

        foreach ($steps as $index => $stepData) {
            $step = Step::create([
                'goal_id' => $goal->id,
                'title' => $stepData['title'],
                'description' => $stepData['description'],
                'order' => $index + 1,
                'status' => 'not_started',
                'progress' => 0,
                'target_date' => now()->addMonths(10)->addWeeks(($index + 1) * 2),
            ]);

            $taskTitles = TaskFactory::tasksFor($stepData['title']);

            foreach ($taskTitles as $taskIndex => $taskTitle) {
                Task::create([
                    'step_id' => $step->id,
                    'title' => $taskTitle,
                    'order' => $taskIndex + 1,
                    'status' => 'not_started',
                    'priority' => $taskIndex === 0 ? 'high' : 'medium',
                    'progress' => 0,
                    'target_date' => now()->addMonths(10)->addDays(($taskIndex + 1) * 5),
                ]);
            }
        }
    }

    // ── Progress bubble-up helper ─────────────────────────────────────

    /**
     * Recompute progress from the bottom up:
     * subtasks → tasks → steps → goal
     */
    private function recomputeAll(Goal $goal): void
    {
        $goal->load('steps.tasks.subtasks');

        foreach ($goal->steps as $step) {
            foreach ($step->tasks as $task) {
                if ($task->subtasks->isNotEmpty()) {
                    $total = $task->subtasks->count();
                    $completed = $task->subtasks->where('is_completed', true)->count();
                    $progress = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

                    $task->update([
                        'progress' => $progress,
                        'status' => $task->status === 'completed' ? 'completed'
                            : ($progress > 0 ? 'in_progress' : 'not_started'),
                        'completed_at' => $task->status === 'completed' ? $task->completed_at : null,
                    ]);
                }
            }

            // Recompute step from tasks
            $totalTasks = $step->tasks->count();
            $completedTasks = $step->tasks->where('status', 'completed')->count();
            $stepProgress = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

            $step->update([
                'progress' => $stepProgress,
                'status' => $stepProgress === 100 ? 'completed'
                    : ($stepProgress > 0 ? 'in_progress' : $step->status),
            ]);
        }

        // Recompute goal from steps
        $goal->recomputeProgress();
    }
}