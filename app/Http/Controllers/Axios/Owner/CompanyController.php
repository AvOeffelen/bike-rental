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

        $isWorkplace = 0;
        if($request['is_workplace'] == true){
            $isWorkplace = 1;
        }
        $locationData = [];

        dd($isWorkplace);
        foreach($request['locations'] as $index => $location){
            $location = Location::create([
                'name' => $location['name'],
                'address' => $location['address'],
                'number' => $location['number'],
                'postalcode' => $location['postalcode'],
                'is_workplace' => $isWorkplace
            ]);
            array_push($locationData,$location->id);
        }

        $locations = Location::whereIn('id',$locationData)->get();

        $invite = new InviteController();
        $invite->createInvite(json_encode($locationData));

        return response()->json($locations);
    }
}
