<?php


namespace App\Helpers;


use App\Model\Bicycle;
use App\Model\BicycleHistory;

class BicycleHistoryHelper
{
    public function storeBicycleEvent(Array $data)
    {
        return BicycleHistory::create([
            'bicycle_id' => $data['id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }

}
