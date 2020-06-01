<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Bicycle;
use App\Model\BicycleRepair;
use App\Model\Location;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getLocations()
    {
        if (auth()->user()->isOwner()) {
            $locations = Location::withCount('bicycle')->where('is_workplace', 0)->latest()->limit(10)->get();
        } else if (auth()->user()->isLocationManager()) {
            $locations = Location::withCount('bicycle')->where('managed_by', auth()->user()->id)->where('is_workplace', 0)->latest()->limit(10)->get();
        }
        return $locations;
    }

    public function getBicycles()
    {
        $bicycles = Bicycle::latest()->limit(10)->get();
        return $bicycles;
    }

    public function getCounters()
    {
        $bicycles = Bicycle::all();
        $repairs = BicycleRepair::all();
        $locations = Location::all();
        $repairsFinished = BicycleRepair::where('is_finished', 1)->get();
        $repairsCurrently = BicycleRepair::where('in_progress',1)->get();

        $counters = [
            'bikes' => count($bicycles),
            'repairs' => count($repairs),
            'locations' => count($locations),
            'repairsFinished' => count($repairsFinished),
            'repairsCurrently' => count($repairsCurrently)

        ];

        return $counters;
    }
}
