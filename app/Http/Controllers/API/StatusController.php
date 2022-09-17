<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StatusResource;
use App\Http\Controllers\Controller;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();

        return StatusResource::collection($statuses);
    }
}
