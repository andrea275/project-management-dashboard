<?php

namespace App\Models;

use App\Rules\UserNotProjectMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    static function rules(Project $project) {
        return [
            'email' => ['required', 'email', 'max:255', new UserNotProjectMember($project)],
            'isAdmin' => ['required', 'boolean']
        ];
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
