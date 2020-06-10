<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\Bicycle;
use App\Model\BicycleHistory;
use App\Model\BicycleRepair;
use App\Model\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BicycleController extends Controller
{

    public function getBicycles()
    {
        $bicycles = Bicycle::with('BicycleHistory')->get();
        return json_encode($bicycles);
    }

    public function paginateBicycles()
    {
        $bicycles = Bicycle::with('Location')->paginate(10);
        return $bicycles;
    }

    public function deleteBicycle(Bicycle $bicycle)
    {
        $bicycleHistories = BicycleHistory::where('id', $bicycle->id)->get();
        $bicycleRepairs = BicycleRepair::where('id', $bicycle->id)->get();

        $bicycle->BicycleHistory()->delete();
        $bicycle->BicycleRepair()->delete();
        $bicycle->delete();
    }

    //Might wanna make the framenumber unique???
    public function updateBicycle(Request $request, Bicycle $bicycle)
    {
        $messages = [
            'framenumber.required' => 'Frame nummer is verplicht',
            'framenumber.min' => 'Framenummer vereist minimaal 1 karakter',
            'framenumber.max' => 'Framenummer mag maximaal 25 karakters bevatten.',
            'lease_end.after_or_equal' => 'Eind datum kan niet eerder zijn dan start datum'
        ];

        $validatedData = $request->validate([
            'framenumber' => 'required|min:1|max:25',
            'lease_end' => 'required|sometimes|after_or_equal:lease_start',
        ], $messages);


        $bicycle->framenumber = $request['framenumber'];
        $bicycle->available = $request['available'];
        $bicycle->in_repair = $request['in_repair'];
        $bicycle->lease_end = Carbon::parse($request['lease_end'])->timestamp;
        $bicycle->update();

        return $bicycle;
    }

    //Might wanna make the framenumber unique???
    public function createBicycle(Request $request)
    {
        $messages = [
            'framenumber.required' => 'Frame nummer is verplicht',
            'framenumber.min' => 'Framenummer vereist minimaal 1 karakter',
            'framenumber.max' => 'Framenummer mag maximaal 25 karakters bevatten.',
        ];

        $validatedData = $request->validate([
            'framenumber' => 'required|min:1|max:25',
        ], $messages);


        $array = $request->all();

        $bike = $this->store($array);

        $helperArray = [];
        $helperArray['id'] = $bike->id;
        $helperArray['title'] = 'Fiets toegevoegd';
        $helperArray['description'] = 'Fiets is toegevoegd aan het systeem.';

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);


        return $bike;
    }


    private function store(array $data)
    {

        return Bicycle::create([
            'in_repair' => $data['in_repair'],
            'available' => $data['available'],
            'framenumber' => $data['framenumber']
        ]);
    }

    /*
     * Idk what this function does..
     */
    public function getBicyclesForCustomerForRepair()
    {
        $bicycles = Bicycle::all();
        return $bicycles;
    }

    public function transferBicycleBack(Request $request)
    {
        $bicycle = Bicycle::where('id', $request['id'])->first();
        $bicycle->location_id = null;
        $bicycle->lease_start = null;
        $bicycle->lease_end = null;
        $bicycle->available = 1;
        $bicycle->update();

        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Fiets terug ontvangen';
        $helperArray['description'] = 'Fiets terug in ontvangst genomen. Hij is nu weer beschikbaar voor verhuur';

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bicycle;
    }


    public function transferBicycle(Request $request)
    {

        $messages = [
            'location.required' => 'Een locatie is verplicht',
            'end.after_or_equal' => 'Eind datum van lease moet gelijk zijn of groter dan de start datum',
            'start.before_or_equal' => 'Start datum van lease moet gelijk zijn of eerder dan de eind datum',
            'start.required' => 'Start datum is verplicht.',
            'end.required' => 'Eind datum is verplicht.',
        ];

        $validatedData = $request->validate([
            'location' => 'required',
            'start' => 'required|sometimes|before_or_equal:end',
            'end' => 'required|sometimes|after_or_equal:start',
        ], $messages);


        $bicycle = Bicycle::where('id', $request['bicycle']['id'])->first();
        $bicycle->location_id = $request['location']['id'];
        $bicycle->lease_start = Carbon::parse($request['start'])->timestamp;
        $bicycle->lease_end = Carbon::parse($request['end'])->timestamp;
        $bicycle->available = 0;
        $bicycle->update();

        $location = Location::where('id', $request['location']['id'])->first();


        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Fiets verhuurd';
        $helperArray['description'] = 'Fiets word verhuurd aan locatie: ' .
            $location->name .
            '. periode start op ' .
            $bicycle->lease_start->format('d-m-Y') .
            ' en eindigd op ' . $bicycle->lease_end->format('d-m-Y') . '.';

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bicycle;
    }
}
