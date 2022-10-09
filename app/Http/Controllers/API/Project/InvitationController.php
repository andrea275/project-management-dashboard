<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Resources\ProjectResource;
use App\Http\Controllers\Controller;
use App\Models\InvitedUser;
use App\Models\Project;

class InvitationController extends Controller
{
    public function index()
    {
        $invited = InvitedUser::whereEmail(auth()->user()->email)->get()->pluck('project_id');

        $projects = Project::whereIn('id', $invited)->get();

        return ProjectResource::collection($projects);
    }
}
