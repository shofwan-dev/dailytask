<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (or create one if doesn't exist)
        $user = User::first();
        
        if (!$user) {
            echo "No users found. Please create a user first.\n";
            return;
        }

        // Sample projects
        $projects = [
            [
                'name' => 'Website Redesign',
                'description' => 'Redesign company website dengan UI/UX modern',
                'status' => 'active',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Develop aplikasi mobile untuk iOS dan Android',
                'status' => 'active',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(45),
            ],
            [
                'name' => 'Marketing Campaign Q1',
                'description' => 'Campaign marketing untuk quarter pertama',
                'status' => 'completed',
                'start_date' => now()->subDays(60),
                'end_date' => now()->subDays(10),
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'user_id' => $user->id,
                'name' => $projectData['name'],
                'description' => $projectData['description'],
                'status' => $projectData['status'],
                'start_date' => $projectData['start_date'],
                'end_date' => $projectData['end_date'],
            ]);

            // Add some sample tasks for each project
            $taskCount = rand(3, 7);
            for ($i = 1; $i <= $taskCount; $i++) {
                Task::create([
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'title' => "Task {$i} - {$project->name}",
                    'description' => "Sample task untuk project {$project->name}",
                    'due_date' => now()->addDays(rand(1, 30)),
                    'due_time' => sprintf('%02d:00', rand(9, 17)),
                    'status' => rand(0, 1) ? 'done' : 'pending',
                    'wa_notified' => false,
                ]);
            }

            echo "Created project: {$project->name} with {$taskCount} tasks\n";
        }

        echo "\nProject seeding completed!\n";
    }
}
