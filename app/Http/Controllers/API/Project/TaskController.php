<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\DeleteTask;
use App\Http\Requests\Task\StoreTask;
use App\Http\Requests\Task\UpdateTask;
use App\Http\Requests\Task\UpdateTaskStatus;
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
        $order = Task::where('project_id', $project->id)->where('status_id', $request->status)->max('order');

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $order ? $order + 1 : 1,
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
            'description' => $request->description,
            'status_id' => $request->status,
            'priority_id' => $request->priority,
            'project_id' => $project->id
        ]);

        $users = User::whereIn('token', $request->users)->get()->pluck('id');
        $task->users()->sync($users);

        return new TaskResource($task);
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return new TaskResource($task);
    }

    public function updateStatus(UpdateTaskStatus $request, Project $project, Task $task)
    {
        foreach ($request->orders as $order) {
            $orderTask = Task::where('uuid', $order['uuid'])->first();
            $orderTask->update([
                'order' => $order['order'] + 1
            ]);
        }

        $task->status_id = $request->status;
        $task->save();

        return new TaskResource($task);
    }
}
