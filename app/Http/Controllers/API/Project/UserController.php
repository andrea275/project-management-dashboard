<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Requests\User\UpdateUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;

class UserController extends Controller
{
    public function index(Project $project)
    {
        $term = request()->query('term');
        $role = request()->query('admin');

        $users = $project->users();

        if ($term) $users = $users->where(function ($query) use ($term) {
            return $query->where('name', 'like', '%' . $term . '%')->orWhere('email', 'like', '%' . $term . '%');
        });
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

    public function destroy(Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return new UserResource($user);
    }

    public function isAdmin(Project $project)
    {
        return auth()->user()->isAdmin($project);
    }
}
