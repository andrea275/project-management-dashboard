<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\InvitedUserResource;
use App\Http\Controllers\Controller;
use App\Models\InvitedUser;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = InvitedUser::whereEmail(auth()->user()->email)->get();

        return InvitedUserResource::collection($invitations);
    }
}
