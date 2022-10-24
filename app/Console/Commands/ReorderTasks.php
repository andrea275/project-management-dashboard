<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Status;

class ReorderTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reorder:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reorder tasks.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $projects = Project::all();
        $statuses = Status::all();

        foreach ($projects as $project) {
            foreach ($statuses as $status) {
                $tasks = Task::where('project_id', $project->id)->where('status_id', $status->id)->orderBy('order')->get();

                foreach ($tasks as $index => $task) {
                    $task->order = $index + 1;
                    $task->save();
                }
            }
        }

        return 0;
    }
}
