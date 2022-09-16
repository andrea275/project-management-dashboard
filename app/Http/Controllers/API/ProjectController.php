<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Project\DeleteProject;
use App\Http\Requests\Project\UpdateProject;
use App\Http\Requests\Project\StoreProject;
use App\Http\Resources\ProjectResource;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return ProjectResource::collection($projects);
    }

    public function store(StoreProject $request)
    {
        $project = Project::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProject $request, Project $project)
    {
        $project = $project->update([
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        return new ProjectResource($project);
    }

    public function destroy(DeleteProject $request, Project $project)
    {
        $project->delete();

        return new ProjectResource($project);
    }
}
