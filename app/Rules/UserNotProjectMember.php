<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Project;
use App\Models\User;

class UserNotProjectMember implements Rule
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function passes($attribute, $value)
    {
        $user = User::whereEmail($value)->first();

        if (empty($user)) return true;

        return !$user->projects->contains($this->project->id);
    }

    public function message()
    {
        return 'User with this email is already a member of this project.';
    }
}
