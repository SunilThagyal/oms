<?php

namespace App\Http\Controllers\Oms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OmsController extends Controller
{
    public function index()
    {
        return view('oms.dashboard');
    }
}
