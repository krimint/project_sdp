<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\Menu;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::latest()->get();
        return view('meja.index',compact('mejas'));
    }
}
