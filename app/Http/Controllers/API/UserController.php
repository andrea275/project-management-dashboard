<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Profile\UpdatePassword;
use App\Http\Requests\Profile\UpdateProfile;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getAuth()
    {
        return new UserResource(auth()->user());
    }

    public function updateProfile(UpdateProfile $request)
    {
        if ($request->hasFile('image')) {
            $rand = Str::random(12);
            $ext = $request->file('image')->getClientOriginalExtension();
            $imgName = "$rand.$ext";
            $request->file('image')->storeAs('users', $imgName, 'public');

            auth()->user()->image = $imgName ? "users/$imgName" : '';
        }

        auth()->user()->name = $request->name;
        auth()->user()->save();

        return new UserResource(auth()->user());
    }

    public function updatePassword(UpdatePassword $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return new UserResource(auth()->user());
    }
}
