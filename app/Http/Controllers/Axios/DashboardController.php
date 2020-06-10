<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Bicycle;
use App\Model\BicycleRepair;
use App\Model\Location;
use Illuminate\Database\Eloquent\Collection;
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

    //TODO:: Fix this to user type.
    public function getBicycles()
    {
        if (auth()->user()->isOwner()) {
            $bicycles = Bicycle::latest()->limit(10)->get();
        } else if (auth()->user()->isLocationManager()) {
            $locations = Location::where('managed_by', auth()->user()->id)->with('bicycle')->get();
            $bicycles = new Collection();
            foreach ($locations as $index => $location) {
                foreach ($location->bicycle as $bicycle) {
                    $bicycles->push($bicycle);
                }
            }
        }

        return $bicycles;
    }

    public function getCounters()
    {

        if (auth()->user()->isOwner()) {
            $bicycles = Bicycle::all();
            $locations = Location::all();
        } else if (auth()->user()->isLocationManager()) {
            $locations = Location::where('managed_by', auth()->user()->id)->with('bicycle')->get();
            $bicycles = new Collection();
            foreach ($locations as $index => $location) {
                foreach ($location->bicycle as $bicycle) {
                    $bicycles->push($bicycle);
                }
            }

        } else if (auth()->user()->isMechanic()) {
            $bicycles = Bicycle::all();
            $locations = Location::all();
        }

        $repairs = BicycleRepair::where('granted',1)->where('in_progress', 0)->where('is_finished', 0)->get();
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
