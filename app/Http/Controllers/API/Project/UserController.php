<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Resources\InvitationResource;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\DetachUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Models\Invitation;
use App\Mail\InviteUser;
use App\Models\Project;
use App\Models\User;

class UserController extends Controller
{
    public function index(Project $project)
    {
        $term = request()->query('term');
        $role = request()->query('admin');

        $users = $project->users();

        if ($term) $users = $users->where('name', 'like', '%' . $term . '%');
        if ($role === 'admin') $users = $users->wherePivot('is_admin', true);
        if ($role === 'editor') $users = $users->wherePivot('is_admin', false);

        $users = $users->get();

        return UserResource::collection($users);
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

    //todo change request name
    public function invite(StoreUser $request, Project $project)
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
}
