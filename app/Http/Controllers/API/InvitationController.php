<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Invitation\AcceptInvitation;
use App\Http\Requests\Invitation\DeleteInvitation;
use App\Http\Resources\InvitationResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Invitation;
use App\Models\User;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::whereEmail(auth()->user()->email)->where('accepted', false)->get();

        return InvitationResource::collection($invitations);
    }

    public function destroy(DeleteInvitation $request, Invitation $invitation)
    {
        $invitation->delete();

        return new InvitationResource($invitation);
    }

    public function accept(AcceptInvitation $request, Invitation $invitation)
    {
        $user = User::whereEmail($invitation->email)->first();

        $invitation->project->users()->attach($user->id, ['is_admin' => $invitation->is_admin]);

        $invitation->accepted = true;
        $invitation->save();

        return new UserResource($user);
    }
}
