<?php

namespace App\Http\Controllers\Oms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OmsCustomerController extends Controller
{
    public function list()
    {
        return view('oms.customer.list');
    }
}
