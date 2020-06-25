<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function get3Months()
    {
        $date = Carbon::now();

        return $date->addMonths(3)->format('d-m-Y');
    }
    public function getToday()
    {
        $date = Carbon::now();

        return $date->format('d-m-Y');
    }
}
