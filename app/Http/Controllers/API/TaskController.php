<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\DeleteTask;
use App\Http\Requests\Task\StoreTask;
use App\Http\Requests\Task\UpdateTask;
use App\Http\Resources\TaskResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = Task::where('project_id', $project->id)->get();

        return TaskResource::collection($tasks);
    }

    public function store(StoreTask $request, Project $project)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status_id' => $request->status,
            'priority_id' => $request->priority,
            'project_id' => $project->id,
            'user_id' => auth()->id()
        ]);

        $users = User::whereIn('token', $request->users)->get()->pluck('id');
        $task->users()->attach($users);

        return new TaskResource($task);
    }

    public function show(Project $project, Task $task)
    {
        return new TaskResource($task);
    }

    public function update(UpdateTask $request, Project $project, Task $task)
    {
        $task = $task->update([
            'title' => $request->title,
            'project_id' => $project->id,
            'user_id' => auth()->id(),
        ]);

        $users = User::whereIn('token', $request->users)->get()->pluck('id');
        $task->users()->sync($users);

        return new TaskResource($task);
    }

    public function destroy(DeleteTask $request, Project $project, Task $task)
    {
        $task->delete();

        return new TaskResource($task);
    }
}
