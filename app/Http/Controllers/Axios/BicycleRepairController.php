<?php

namespace App\Http\Controllers\Axios;

use App\Helpers\BicycleHistoryHelper;
use App\Http\Controllers\Controller;
use App\Model\BicycleRepair;
use Illuminate\Http\Request;

class BicycleRepairController extends Controller
{

    //TODO:: Fix this so that's bound to the location?
    public function getBicyclesInRepair()
    {
        $bicycles = BicycleRepair::where('is_finished',0)->with('Bicycle')->get();
        return $bicycles;
    }

    public function requestRepair(Request $request)
    {
        $data =[];
        $data['bicycle_id'] = $request['bicycle']['id'];
        $data['description'] = $request['description'];

        $bike = $this->storeRepair($data);

        $helperArray = [];
        $helperArray['id'] = $bike->id;
        $helperArray['title'] = 'Repair has been requested.';
        $helperArray['description'] = $request['description'];

        $bikeHelper = new BicycleHistoryHelper();
        $bikeHelper->storeBicycleEvent($helperArray);

        return $bike;
    }

    private function storeRepair(array $data){
        return BicycleRepair::create([
            'bicycle_id' => $data['bicycle_id'],
            'description' => $data['description']
        ]);
    }
}
