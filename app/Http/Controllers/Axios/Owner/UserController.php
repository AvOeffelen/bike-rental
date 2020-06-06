<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use App\Mail\Invite;
use App\Model\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::where('type','!=',['admin'])->get();

        return $users;
    }

    public function sendInvite(Request $request)
    {
        $invite = new InviteController();
        $invite = $invite->createInvite(null,$request['type']);


        Mail::to($request['email'])->send(new Invite($invite));

        return response()->json($invite);
    }

    public function removeUser(User $user)
    {
        if($user->isLocationManager()){
            $locations = Location::where('managed_by',$user->id)->get();
            foreach($locations as $location){
                $location->managed_by = null;
                $location->update();
            }

        }
        $user->delete();
    }
}
