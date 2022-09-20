<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Resources\PriorityResource;
use App\Http\Controllers\Controller;
use App\Models\Priority;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::all();

        return PriorityResource::collection($priorities);
    }
}
