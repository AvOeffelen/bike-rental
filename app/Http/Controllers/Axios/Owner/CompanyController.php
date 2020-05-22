<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use App\Model\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function post(Request $request)
    {
        $messages = [
            'locations.*.name.required' => 'De locatie naam is verplicht',
            'locations.*.number.required' => 'Het huisnummer(TBD) is verplicht',
            'locations.*.street.required' => 'De straatnaam is verplicht',
            'locations.*.postalcode.required' => 'De postcode is verplicht',
            'locations.*.*.min' => 'Het veld moet minimaal 3 karakters bevatten',
            'contact.email.unique' => 'Dit email adres is al in gebruik.',
            'contact.lastname.required' => 'Achternaam is verplicht',
            'contact.name.required' => 'Voornaam is verplicht',
            'contact.email.required' => 'E-mail is verplicht',
            'contact.name_addition.max'=> 'Tussenvoegsel mag niet langer zijn dan 5 karakters'
        ];
        $validatedData = $request->validate([
            'contact.email' => 'bail|unique:users',
            'locations.*.*' => 'required',
            'locations.*.street' => 'max:25',
            'locations.*.number' => 'min:1',
            'contact.*' => 'required',
            'contact.name_addition' => 'sometimes|max:5'
        ],$messages);


        $locationData = [];

        //TODO:: change street in vue to adress
        foreach($request['locations'] as $index => $location){
            $location = Location::create([
                'name' => $location['name'],
                'address' => $location['street'],
                'number' => $location['number'],
                'postalcode' => $location['postalcode']
            ]);
            array_push($locationData,$location->id);
        }


        $invite = new InviteController();
        $invite->createInvite(json_encode($locationData));



    }

    //TODO:: Change the standard password to the random generator.
    protected function createUser($data){

//        $pw = Str::random(10);
        $pw = '123456789';
        return User::create([
            'name' => $data['name'],
            'lastname_addition' => $data['name_addition'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($pw),
            'phone' => $data['phone']
        ]);
    }
}
