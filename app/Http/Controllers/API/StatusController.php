<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StatusResource;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();

        return StatusResource::collection($statuses);
    }

    public function statusWithTaskCount(Project $project)
    {
        $statuses = Status::withCount(['tasks' => function (Builder $query) use ($project) {
            return $query->where('project_id', $project->id);
        }])->get();

        $arr = [];

        foreach ($statuses as $status) {
            $arr[] = [
                'name' => $status->name,
                'color' => $status->color,
                'tasks' => $status->tasks_count
            ];
        }

        return $arr;
    }
}
