<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\DetachUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use App\Models\User;

class UserController extends Controller
{
    public function index(Project $project)
    {
        return UserResource::collection($project->users);
    }

    public function store(StoreUser $request, Project $project)
    {
        $user = User::firstOrCreate([
            'email' => $request->email
        ], [
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);

        $project->users()->attach($user->id, ['is_admin' => $request->isAdmin]);

        return new UserResource($user);
    }

    public function show(Project $project, User $user)
    {
        return new UserResource($user);
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
}
