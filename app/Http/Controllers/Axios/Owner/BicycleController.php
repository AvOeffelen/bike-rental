<?php

namespace App\Http\Controllers\Axios\Owner;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\Bicycle;
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
    public function updateBicycle(Request $request,Bicycle $bicycle)
    {

        $bicycle->framenumber = $request['framenumber'];
        $bicycle->available = $request['available'];
        $bicycle->in_repair = $request['in_repair'];
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
        $helperArray['title'] = 'Bicycle added to the system';
        $helperArray['description'] = 'A new bicycle has been added to the system';

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
    public function getBicyclesForCustomerForRepair()
    {
        $bicycles = Bicycle::all();
        return $bicycles;
    }
}
