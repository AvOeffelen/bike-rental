<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        return response()->view('repair.index');
    }
}
