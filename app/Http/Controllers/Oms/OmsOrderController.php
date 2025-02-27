<?php

namespace App\Http\Controllers\Oms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OmsOrderController extends Controller
{
    public function list()
    {
        return view('oms.orders.list');
    }
}
