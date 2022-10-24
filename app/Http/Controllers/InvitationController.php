<?php

namespace App\Http\Controllers;

class InvitationController
{
    public function __invoke()
    {
        return view('pages.invitations');
    }
}
