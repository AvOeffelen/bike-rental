<?php

namespace App\Http\Controllers;

use App\Model\Invite;
use App\Model\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    //

    public function signUp($inviteCode)
    {
        $invite = Invite::where('code',$inviteCode)->get();
        return view('auth.register',[
            'invite' => $invite->first()
        ]);
    }

    public function finishSignUp(Request $request,Invite $invite)
    {

        if($invite->used === 1){
            return redirect()->back();
        }
        $this->validator($request);
        $user = $this->createUser($request->all());


        $this->linkLocationToUser(json_decode($invite->data),$user);

        Auth::loginUsingId($user->id);
        $this->updateInvite($invite);
        return response()->redirectToRoute('home');
    }
    public function validator(Request $request)
    {
        $message = [

        ];
        return $this->validate($request, [
            'name' => 'required|string|max:255',
            'addition' => 'string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|digits_between:9,15',
        ],$message);
    }
    //TODO:: Create user
    protected function createUser($data){
        return User::create([
            'name' => $data['name'],
            'lastname_addition' => $data['addition'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    //TODO:: Link the locations to user.
    protected function linkLocationToUser($locations,User $user){

        $locations = Location::where('id',$locations)->get();
        dd($locations);
    }

    protected function updateInvite(Invite $invite){
        $invite->used = 1;

        return $invite->update();
    }
}
