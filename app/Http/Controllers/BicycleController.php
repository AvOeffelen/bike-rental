<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BicycleController extends Controller
{
    public function index()
    {
        return response()->view('bicycles.index');
    }

    public function showTimeline()
    {

        return response()->view('bicycles.timeline.index');
    }
}
