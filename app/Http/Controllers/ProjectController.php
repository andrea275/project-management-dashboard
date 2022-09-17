<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function __invoke(Project $project)
    {
        return view('pages.project.show', compact('project'));
    }
}
