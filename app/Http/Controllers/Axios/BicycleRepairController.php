<?php

namespace App\Http\Controllers\Axios;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\Bicycle;
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
        $bicycles = BicycleRepair::where('granted',0)->where('is_finished',0)->with('Bicycle.Location')->get();
        return $bicycles;
    }

    public function getBicyclesRepairGranted()
    {
        $bicycles = BicycleRepair::where('granted',1)->where('is_finished',0)->with('bicycle')->get();

        return $bicycles;
    }

    //TODO:: check this function. This might need a rework.
    public function acceptRequest(Request $request)
    {

        $requestBike = BicycleRepair::where('id',$request['bicycle']['id'])->first();

        $bike = $requestBike->Bicycle;

        $helperArray = [];

        $location = Location::where('is_workplace',1)->first();

        if($request['replacement'] === true && $request['fixOnLocation'] === false ){

            $replacementBicycle = Bicycle::where('id',$request['bicycle_replacement']['id'])->first();
            $this->ReplaceBicycle($replacementBicycle,$bike->location_id,$bike->lease_start,$bike->lease_end);

            $bike->lease_start = null;
            $bike->lease_end = null;

            $bike->location_id = $location->id;
            $requestBike->granted = 1;

            $helperArray['id'] = $bike->id;
            $helperArray['title'] = 'Aanvraag reparatie is geaccepteerd.';
            $helperArray['description'] = "Omschrijving klant: \"". $request['description'] . "\". De fiets word mee genomen naar de volgende locatie. " . $location->name. ".";

            $requestBike->update();
            $bike->update();

        } else if($request['replacement'] === false && $request['fixOnLocation'] === true ){
            $requestBike->is_finished = 1;
            $requestBike->finished_at = Carbon::parse(Carbon::now()->timestamp);

            $bike->requested_repair = 0;

            $helperArray['id'] = $bike->id;
            $helperArray['title'] = 'Aanvraag reparatie is geaccepteerd.';
            $helperArray['description'] =
                "Omschrijving klant: \"". $request['bicycle']['description'] .
                "\". De fiets is ter plaatse gerepareerd. De monteur heeft het volgende geschreven: \""
                . $request['repair_description'] . "\" ";


            $requestBike->update();
            $bike->update();

        } else {
            $helperArray['id'] = $bike->id;
            $helperArray['title'] = 'Aanvraag reparatie is geaccepteerd.';
            $helperArray['description'] = "Omschrijving klant: \"". $request['description'] . "\". De fiets word mee genomen naar de volgende locatie. " . $location->name. ".";

            $bike->location_id = $location->id;
            $requestBike->granted = 1;

            $requestBike->update();
            $bike->update();
        }

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
        $bike = BicycleRepair::where('id',$request['bicycle']['id'])->with('bicycle')->first();
        $bike->in_progress = 0;
        $bike->is_finished = 1;
        $bike->finished_at = Carbon::parse(Carbon::now()->timestamp);
        $bike->update();

        $bicycle = $bike->bicycle;
        $bicycle->in_repair = 0;
        $bicycle->requested_repair = 0;
        $bicycle->available = 1;
        $bicycle->location_id = null;
        $bicycle->lease_start = null;
        $bicycle->lease_end = null;
        $bicycle->update();



        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Reparatie voltooid.';
        $helperArray['description'] = "Omschrijving klant: \"". $request['bicycle']['description'] . "\". Reparatie gestart op: "
            . $bike->started_at->format('d-m-Y') . " en is afgerond op: ". $bike->started_at->format('d-m-Y') .". De monteur heeft het volgende geschreven:\"".$request['description']."\"." ;

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

    protected function ReplaceBicycle(Bicycle $bicycle,$location_id,$start,$end){
        $bicycle->location_id = $location_id;
        $bicycle->lease_start = $start;
        $bicycle->available = 0;
        $bicycle->lease_end = $end;
        $bicycle->update();

        $helperArray = [];
        $helperArray['id'] = $bicycle->id;
        $helperArray['title'] = 'Fiets verhuurd';
        if($start == null && $end === null) {

            $helperArray['description'] = 'Fiets word verhuurd aan locatie: ' .
                $bicycle->location->name .
                '. Lease periode is onbekend.';
        }else {

            $helperArray['description'] = 'Fiets word verhuurd aan locatie: ' .
                $bicycle->location->name .
                '. periode start op ' .
                $bicycle->lease_start->format('d-m-Y') .
                ' en eindigd op ' . $bicycle->lease_end->format('d-m-Y') . '.';
        }

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bicycle;
    }
}
