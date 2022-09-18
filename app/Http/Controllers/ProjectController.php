<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function tasks(Project $project)
    {
        return view('pages.project.tasks', compact('project'));
    }

    public function users(Project $project)
    {
        return view('pages.project.users', compact('project'));
    }
}
