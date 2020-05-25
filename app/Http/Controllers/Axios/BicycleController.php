<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Bicycle;
use Illuminate\Http\Request;

class BicycleController extends Controller
{

    //TODO:: Add the where later
    public function getBicyclesForCustomerForRepair()
    {
        $bicycles = Bicycle::all();
        return $bicycles;
    }


}
