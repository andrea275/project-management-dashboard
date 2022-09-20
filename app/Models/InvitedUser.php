<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitedUser extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            do {
                $token = Str::random();
            } while (!empty(User::whereToken($token)->first()));

            $user->token = $token;
        });
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    protected $guarded = ['id'];
}
