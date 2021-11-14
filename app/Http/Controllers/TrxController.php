<?php

namespace App\Http\Controllers;

use App\Models\Trx;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Paket;
use App\Models\DetailTrx;
use Illuminate\Http\Request;

class TrxController extends Controller
{
    public function index(){
        $transaksi = Trx::join('mejas','mejas.id','=','trxes.meja_id')
        ->get(['mejas.nama as nama_meja','trxes.status','trxes.total_payment']);
        // return $transaksi;
        $meja = Meja::where('status','1')->get();
        $menu = Menu::where('status','1')->get();
        return view('trx.index',compact(['transaksi','meja','menu']));
    }

    public function getPaket(){
        $paket = Paket::where('status','1')->get();
        return response()->json($paket);
    }

    public function store(Request $request){

        $total_payment = 0;

        for ($i=0; $i < count($request->menu); $i++) {
            $price = Menu::where('id',$request->menu[$i])->first();
            $total_payment = $total_payment + ($price->harga * $request->qty[$i]);
        }

        $trx = Trx::create([
            'user_id' => auth()->user()->id,
            'meja_id' => $request->meja[0],
            'status' => 0,
            'total_payment' => $total_payment,
        ]);


        for ($i=0; $i < count($request->menu); $i++) {
            DetailTrx::create([
                'trx_id' => $trx->id,
                'jenis' => $request->jenis[$i],
                'id_jenis' => $request->menu[$i],
                'qty' => $request->qty[$i],
                'status_payment' => 0,
                'jenis_payment' => '',
            ]);
        }

        Meja::where('id',$request->meja[0])->update(['status' =>0]);

        return redirect('trx')->with('success', 'Transaksi berhasil ditambahkan');

    }

    public function report(){
        $report = DetailTrx::with('trx')->get();
        // return $report;
        return view('trx.report',compact('report'));
    }
}
