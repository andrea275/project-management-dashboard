<?php

namespace App\Mail;

use App\Models\InvitedUser;
use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $project;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite-user', [
            'projectName' => $this->project->title,
            'userName' => $this->user->name,
        ]);
    }
}
