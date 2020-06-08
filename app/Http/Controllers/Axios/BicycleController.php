<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Bicycle;
use Illuminate\Http\Request;

class BicycleController extends Controller
{


    public function getBicyclesForCustomerForRepair()
    {
        $bicycles = Bicycle::all();
        return $bicycles;
    }

    public function getAvailableBicycles()
    {
        $bicycles = Bicycle::where('available',1)->where('in_repair',0)->whereNull('lease_start')->whereNull('lease_end')->whereNull('location_id')->get();

        return $bicycles;
    }

}
