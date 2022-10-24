<?php

namespace App\Http\Controllers;

class ProfileController
{
    public function __invoke()
    {
        return view('pages.profile');
    }
}
