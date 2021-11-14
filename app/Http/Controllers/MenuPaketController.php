<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class MenuPaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();
        return view('menupaket.index',compact('pakets'));
    }

}
