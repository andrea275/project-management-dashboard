<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Resources\InvitedUserResource;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\DetachUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Models\InvitedUser;
use App\Mail\InviteUser;
use App\Models\Project;
use App\Models\User;

class UserController extends Controller
{
    public function index(Project $project)
    {
        return UserResource::collection($project->users);
    }

    public function update(UpdateUser $request, Project $project, User $user)
    {
        $project->users()->updateExistingPivot($user->id, ['is_admin' => $request->isAdmin]);

        return new UserResource($user);
    }

    public function destroy(DetachUser $request, Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return new UserResource($user);
    }

    public function invite(StoreUser $request, Project $project)
    {
        $invitedUser = InvitedUser::updateOrCreate([
            'email' => $request->email,
            'user_id' => auth()->id(),
            'project_id' => $project->id
        ], [
            'is_admin' => $request->isAdmin
        ]);

        Mail::to($invitedUser->email)->send(new InviteUser($project, User::find(auth()->id())));

        return new InvitedUserResource($invitedUser);
    }

    public function acceptInvitation(StoreUser $request, Project $project, InvitedUser $invitedUser)
    {
        $user = User::whereEmail($invitedUser->email)->first();

        $project->users()->attach($user->id, ['is_admin' => $request->isAdmin]);

        return new UserResource($user);
    }
}
