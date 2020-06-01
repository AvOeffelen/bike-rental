<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use App\Mail\Invite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::where('type','!=',['owner','admin'])->get();

        return $users;
    }

    public function sendInvite(Request $request)
    {
        $invite = new InviteController();
        $invite = $invite->createInvite(null,$request['type']);


        Mail::to($request['email'])->send(new Invite($invite));

        return response()->json($invite);
    }
}
