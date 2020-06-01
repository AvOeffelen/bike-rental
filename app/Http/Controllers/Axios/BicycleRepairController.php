<?php

namespace App\Http\Controllers\Axios;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\BicycleRepair;
use App\Model\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BicycleRepairController extends Controller
{
    public function getBicyclesCurrentlyInRepair()
    {
        $bicycles = BicycleRepair::where('granted',1)->where('in_progress',1)->where('is_finished',0)->with('bicycle')->get();

        return $bicycles;
    }

    public function getBicyclesInRepair()
    {
        $bicycles = BicycleRepair::where('granted',0)->where('is_finished',0)->with('Bicycle')->get();
        return $bicycles;
    }

    public function getBicyclesRepairGranted()
    {
        $bicycles = BicycleRepair::where('granted',1)->where('is_finished',0)->with('bicycle')->get();

        return $bicycles;
    }

    public function acceptRequest(Request $request)
    {
        $requestBike = BicycleRepair::where('id',$request['id'])->first();

        $requestBike->granted = 1;
        $requestBike->update();

        $bike = $requestBike->Bicycle;
        $oldLocation = $bike->location->name;


        $location = Location::where('is_workplace',1)->first();

        $bike->location_id = $location->id;
        $bike->update();

        $helperArray = [];
        $helperArray['id'] = $bike->id;
        $helperArray['title'] = 'Aanvraag reparatie is geaccepteerd.';
        $helperArray['description'] = "Omschrijving klant: \"". $request['description'] . "\". De fiets is verplaatst naar volgende locatie: " . $location->name. ".";

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);


        return $bike;
    }

    public function startRepair(Request $request)
    {
        $bike = BicycleRepair::where('id',$request['id'])->with('bicycle')->first();

        $bike->in_progress = 1;
        $bike->started_at = Carbon::parse(Carbon::now()->timestamp);
        $bike->update();

        $bicycle = $bike->bicycle;
        $bicycle->in_repair = 1;
        $bicycle->update();


        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Reparatie gestart.';
        $helperArray['description'] = "Omschrijving klant: \"". $request['description'] . "\". Reparatie gestart op: " . $bike->started_at->format('d-m-Y') . "." ;

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return response()->json($bike);
    }

    public function finishRepair(Request $request)
    {
        $bike = BicycleRepair::where('id',$request['id'])->with('bicycle')->first();
        $bike->in_progress = 0;
        $bike->is_finished = 1;
        $bike->finished_at = Carbon::parse(Carbon::now()->timestamp);
        $bike->update();

        $bicycle = $bike->bicycle;
        $bicycle->in_repair = 0;
        $bicycle->requested_repair = 0;
        $bicycle->available = 1;
        $bicycle->location_id = null;
        $bicycle->update();



        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Reparatie voltooid!';
        $helperArray['description'] = "Omschrijving klant: \"". $request['description'] . "\". Reparatie gestart op: " . $bike->started_at->format('d-m-Y') . " en is afgerond op: ". $bike->started_at->format('d-m-Y') ."." ;

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bike;
    }

    public function requestRepair(Request $request)
    {
        $messages = [
            'description.required' => 'Beschrijving is verplicht'
        ];

        $validatedData = $request->validate([
            'description' => 'required|min:1',
        ],$messages);

        $data =[];
        $data['bicycle_id'] = $request['bicycle']['id'];
        $data['description'] = $request['description'];

        $bike = $this->storeRepair($data);

        $helperArray = [];
        $helperArray['id'] = $bike->bicycle->id;
        $helperArray['title'] = 'Repair has been requested.';
        $helperArray['description'] = $request['description'];

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        $bike->bicycle->requested_repair = 1;
        $bike->bicycle->update();

        return $bike;
    }

    private function storeRepair(array $data){
        return BicycleRepair::create([
            'bicycle_id' => $data['bicycle_id'],
            'description' => $data['description']
        ]);
    }
}
