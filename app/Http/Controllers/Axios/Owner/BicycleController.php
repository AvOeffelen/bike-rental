<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\Bicycle;
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
        $bicycles = Bicycle::paginate(10);
        return json_encode($bicycles);
    }

    //TODO:: remove everything thats connected to this bike.
    //Might be an idea to make bikes nonremoveable when they out for lease.
    public function deleteBicycle(Bicycle $bicycle)
    {
        return $bicycle->delete();
    }

    //TODO:: do bicycle validation
    public function updateBicycle(Request $request, Bicycle $bicycle)
    {
        $bicycle->framenumber = $request['framenumber'];
        $bicycle->available = $request['available'];
        $bicycle->in_repair = $request['in_repair'];
        $bicycle->lease_end = Carbon::parse($request['lease_end'])->timestamp;
        $bicycle->update();

        return $bicycle;
    }


    //TODO:: do bicycle validation
    public function createBicycle(Request $request)
    {
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

    //TODO:: Add the where later
    /*
     * Idk what this function does..
     */
    public function getBicyclesForCustomerForRepair()
    {
        $bicycles = Bicycle::all();
        return $bicycles;
    }

    public function transferBicycle(Request $request)
    {
        $bicyclex = Bicycle::where('id', $request['bicycle']['id'])->get();
        $bicycle = $bicyclex->first();
        $bicycle->location_id = $request['location']['id'];
        $bicycle->lease_start = Carbon::parse($request['start'])->timestamp;
        $bicycle->lease_end = Carbon::parse($request['end'])->timestamp;
        $bicycle->available = 0;
        $bicycle->update();


        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Fiets verhuurd';
        $helperArray['description'] = 'Fiets word verhuurd aan locatie ' .
            $bicycle->Location->name .
            '. periode start op ' .
            $bicycle->lease_start->format('d-m-Y') .
            ' en eindigd op ' . $bicycle->lease_end->format('d-m-Y') . '.';

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bicycle;
    }
}
