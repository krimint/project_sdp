<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{
    //
    // public function index(){
    //     return view('shift');
    // }

    public function cashawal(){
        return view('shift.cashawal');
    }

    public function inputCash(Request $request){
        Shift::create([
            'user_id' => auth()->user()->id,
            'waktu_awal' => date('Y-m-d h:i:s'),
            'cash_awal' => $request->cash_awal
        ]);
        return redirect('dashboard')->with('success', 'Cash awal berhasil ditambahkan');
    }
}
