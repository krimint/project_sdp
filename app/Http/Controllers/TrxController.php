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
        ->get(['trxes.id','trxes.meja_id','mejas.nama as nama_meja','trxes.status','trxes.total_payment']);
        // return $transaksi;
        $meja = Meja::where('status','1')->get();
        $menu = Menu::where('status','1')->get();
        return view('trx.index',compact(['transaksi','meja','menu']));
    }

    public function getPaket(){
        $paket = Paket::where('status','1')->get();
        return response()->json($paket);
    }

    public function hargaMenu(Request $request){
        $menu = Menu::where('id',$request->id)->where('status','1')->first();
        $menu->pluck('harga');
        return response()->json($menu);
    }

    public function hargaPaket(Request $request){
        $hargaPaket = Paket::where('id',$request->id)->where('status','1')->first();
        return response()->json($hargaPaket);
    }

    public function store(Request $request){

        $total_payment = 0;

        for ($i=0; $i < count($request->menu); $i++) {
            if($request->jenis[$i] == 'Single'){
                $price = Menu::where('id',$request->menu[$i])->first();
                $total_payment = $total_payment + ($price->harga * $request->qty[$i]);
            }else {
                $price = Paket::where('id',$request->menu[$i])->first();

                $total_payment = $total_payment + ($price->harga * $request->qty[$i]);
            }
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
        $report = DetailTrx::with('trx')->orderBy('id','desc')->where('status_payment',1)->get();
        foreach($report as $key => $value){
            if($value->jenis == 'Single'){
                $report[$key]['nama_jenis'] = Menu::where('id', $value->id_jenis)->first()->nama;
            }else{
                $report[$key]['nama_jenis'] = Paket::where('id', $value->id_jenis)->first()->nama;
            }

        }
        return view('trx.report',compact('report'));
    }

    public function checkout(Request $request,$id){
        Trx::where('id',$id)->update(['status' =>1]);
        Meja::where('id',$request->meja)->update(['status' =>1]);
        DetailTrx::where('trx_id',$id)->update(['status_payment' =>1,'jenis_payment' => $request->method]);
        return response()->json([
            'success' => true
        ]);
    }
}
