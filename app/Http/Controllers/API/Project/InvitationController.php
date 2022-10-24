<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Requests\Invitation\UpdateInvitation;
use App\Http\Requests\Invitation\StoreInvitation;
use App\Http\Resources\InvitationResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Invitation;
use App\Mail\InviteUser;
use App\Models\Project;
use App\Models\User;

class InvitationController extends Controller
{
    public function index(Project $project)
    {
        $invitations = Invitation::where('project_id', $project->id)->where('accepted', false)->get();

        return InvitationResource::collection($invitations);
    }

    public function store(StoreInvitation $request, Project $project)
    {
        $invitation = Invitation::updateOrCreate([
            'email' => $request->email,
            'user_id' => auth()->id(),
            'project_id' => $project->id
        ], [
            'is_admin' => $request->isAdmin
        ]);

        Mail::to($invitation->email)->send(new InviteUser($project, User::find(auth()->id())));

        return new InvitationResource($invitation);
    }

    public function update(UpdateInvitation $request, Project $project, Invitation $invitation)
    {
        $invitation->is_admin = $request->isAdmin;
        $invitation->save();

        return new InvitationResource($invitation);
    }

    public function resend(Project $project, Invitation $invitation)
    {
        Mail::to($invitation->email)->send(new InviteUser($project, User::find(auth()->id())));

        return new InvitationResource($invitation);
    }
}
