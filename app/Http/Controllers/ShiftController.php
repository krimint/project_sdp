<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

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

    public function cashakhir(){
        return view('shift.cashakhir');
    }

    public function update(Request $request){
        $update = Shift::where('id',$request->id)->update(
            [
                'waktu_akhir' => date('Y-m-d h:i:s'),
                'cash_akhir' => $request->cash_akhir
            ]);
        if($update){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }
}
