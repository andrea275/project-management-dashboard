<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Project::create([
            'title' => 'Finance Mobile App',
            'user_id' => 1
        ]);

        $project->users()->attach(1, ['is_admin' => 1]);

        Task::create([
            'title' => 'Mockups',
            'description' => 'Create 12 mockups with a mobile (iPhone 13) view.',
            'status_id' => 1,
            'priority_id' => 1,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'UI Animation',
            'description' => 'Micro-interaction, Loading and progress, Navigation, Storytelling.',
            'status_id' => 1,
            'priority_id' => 3,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Usability Testing',
            'description' => 'Explorative test, Assessment research, n Comparative research',
            'status_id' => 2,
            'priority_id' => 3,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Front-end Development',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'status_id' => 2,
            'priority_id' => 2,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Back-end Development',
            'description' => 'Nullam tristique ligula et vehicula maximus. Maecenas magna mi, lacinia non elementum vitae, pulvinar in eros.',
            'status_id' => 2,
            'priority_id' => 3,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Illustrations',
            'description' => 'Create 40 illustrations. Clean and minimalist.',
            'status_id' => 3,
            'priority_id' => 4,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Copywrite',
            'description' => 'Writing persuasive messages. Make it simple and clear.',
            'status_id' => 3,
            'priority_id' => 2,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'HI-FI Design',
            'description' => 'Convert the wireframe to high-fidelity/final design.',
            'status_id' => 4,
            'priority_id' => 1,
            'project_id' => $project->id,
            'user_id' => 1
        ]);

        Task::create([
            'title' => 'Wireframe',
            'description' => 'Fusce tincidunt ultricies semper.',
            'status_id' => 4,
            'priority_id' => 2,
            'project_id' => $project->id,
            'user_id' => 1
        ]);
    }
}
