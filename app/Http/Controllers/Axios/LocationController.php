<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Model\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

    public function getAllBicycles()
    {
        $locations = Location::where('managed_by',auth()->user()->id)->with('bicycle')->get();
        $bicycles = new Collection();
        foreach($locations as $index => $location){
            foreach($location->bicycle as $bicycle){
                $bicycles->push($bicycle);
            }
        }

       return $this->paginate($bicycles,10);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
