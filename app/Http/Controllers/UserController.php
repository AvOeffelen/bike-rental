<?php

namespace App\Http\Controllers;

use App\Model\Invite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editProfile()
    {

        return view('profile.edit.index',[
            'user' => Auth::user()
        ]);
    }
    public function continueSignUp()
    {

        return view('profile.create_password.index',[
            'user' => Auth::user()
        ]);
    }
}
