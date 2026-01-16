<?php

namespace App\Modules\BusquedaReserva\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusquedaReservaController extends Controller
{
    public function index()
    {
        return view('modules.busquedareserva.index');
    }
}
