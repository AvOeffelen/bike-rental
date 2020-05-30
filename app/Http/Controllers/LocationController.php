<?php

namespace App\Http\Controllers;

use App\Model\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function showForLocationManager()
    {
        return view('location.manager.index');
    }

    public function showLocation(Location $location)
    {
        $locationx = Location::with('bicycle.BicycleRepair','bicycle')->where('id', $location->id)->get();

        return view('location.overview.index',[
            'location' =>$locationx->first()
        ]);
    }

    public function showWorkplace()
    {

        return view('workplace.index');
    }
}
