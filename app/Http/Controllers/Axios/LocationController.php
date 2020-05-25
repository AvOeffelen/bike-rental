<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function getLocations()
    {
        if(!auth()->user()->isOwner()){
            $locations = Location::where('managed_by',auth()->user()->id)->withCount('bicycle')->get();
        }else{
            $locations = Location::all();
        }

        return json_encode($locations);
    }
}
