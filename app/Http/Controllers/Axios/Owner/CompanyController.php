<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use App\Mail\Invite;
use App\Model\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function post(Request $request)
    {
        if($request['no_contact_person'] == true){
            $messages = [
                'locations.*.name.required' => 'De locatie naam is verplicht',
                'locations.*.number.required' => 'Het huisnummer(TBD) is verplicht',
                'locations.*.address.required' => 'De straatnaam is verplicht',
                'locations.*.postalcode.required' => 'De postcode is verplicht',
                'locations.*.*.min' => 'Het veld moet minimaal 3 karakters bevatten',
                'contact.email.unique' => 'Dit email adres is al in gebruik.',
                'locations.*.unique' => 'Locatie naam moet uniek zijn',
                'contact.lastname.required' => 'Achternaam is verplicht',
                'contact.name.required' => 'Voornaam is verplicht',
                'contact.email.required' => 'E-mail is verplicht',
            ];

            $validatedData = $request->validate([
                'contact.email' => 'bail|unique:users',
                'locations.*.*' => 'required',
                'locations.*.name' => 'unique:location',
                'locations.*.address' => 'max:25',
                'locations.*.number' => 'min:1',
                'contact.*' => 'required',
            ],$messages);
        } else {

            $messages = [
                'locations.*.name.required' => 'De locatie naam is verplicht',
                'locations.*.number.required' => 'Het huisnummer(TBD) is verplicht',
                'locations.*.address.required' => 'De straatnaam is verplicht',
                'locations.*.postalcode.required' => 'De postcode is verplicht',
                'locations.*.*.min' => 'Het veld moet minimaal 3 karakters bevatten',
                'locations.*.unique' => 'Locatie naam moet uniek zijn',
            ];

            $validatedData = $request->validate([
                'locations.*.*' => 'required',
                'locations.*.name' => 'unique:location',
                'locations.*.address' => 'max:25',
                'locations.*.number' => 'min:1',
            ], $messages);
        }


        if($request['is_workplace'] === true){
            $isWorkplace = 1;
        } else {
            $isWorkplace = 0;
        }

        $locationData = [];
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

        if($isWorkplace === 1){
            $type = 'mechanic';
        } else {
            $type = 'location_manager';
        }

        if($request['no_contact_person'] == true) {
            $invite = new InviteController();
            $invite = $invite->createInvite(json_encode($locationData), $type);

            Mail::to($request['contact']['email'])->send(new Invite($invite));
        }

        return response()->json($locations);
    }
}
