<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function getLocations()
    {
        if(auth()->user()->isLocationManager()){
            $locations = Location::where('managed_by',auth()->user()->id)->where('is_workplace',0)->withCount('bicycle')->get();
            return json_encode($locations);
        }
         elseif (auth()->user()->isMechanic()){
            $locations = Location::where('is_workplace',1)->withCount('bicycle')->with('bicycle')->get();
             return json_encode($locations);
        }
        else{
            $locations = Location::withCount('bicycle')->where('is_workplace',0)->get();
            return json_encode($locations);
        }

    }

    public function getBicycles(Location $location)
    {

        return response()->json($location->bicycle);
    }
}
