<?php

namespace App\Http\Controllers;

class InvitationController extends Controller
{
    public function index()
    {
        return view('pages.invitations');
    }
}
