<?php

namespace App\Http\Controllers;

use App\Model\Invite;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function createInvite()
    {
        $code = $this->codeGenerator();

        $this->store($code);
        return $code;
    }

    private function codeGenerator($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function store($code){
        return Invite::create([
            'code' => $code
        ]);
    }
}
