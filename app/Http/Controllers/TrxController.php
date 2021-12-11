<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Trx;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Paket;
use App\Models\DetailTrx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxController extends Controller
{

    public function index(){
        $cek = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('total_payment',0)
        ->latest()->first();
        if(!empty($cek)){
            return redirect('trx/create');
        }
        $meja = Meja::where('status',1)->oldest()->get();
        return view('trx.choose-table',compact('meja'));
    }

    public function chooseTable(Request $request){
        $idMeja = serialize($request->idMeja);
        $idTrx = $request->trx_id;
        if($idTrx > 0){
            $trx = Trx::find($idTrx);
            $oldMeja =  $trx->meja_id;

            $upMeja = Meja::whereIn('id',unserialize($oldMeja))->update(['status' => 1]);
            if($upMeja){
                $trx->update(['meja_id' => $idMeja]);
                Meja::whereIn('id',unserialize($idMeja))->update(['status' => 0]);
            }

            return response()->json([
                'success' => 'Berhasil'
            ]);
        }
        else{
            Trx::create([
                'user_id' => auth()->user()->id,
                'meja_id' => $idMeja
            ]);

            for($i = 0; $i < count($request->idMeja); $i++){
                Meja::where('id',$request->idMeja[$i])->update(['status' => 0]);
            }

            return response()->json([
                'success' => 'Berhasil'
            ]);
        }


    }

    public function create(){
        $cek = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('status',0)
        ->latest()->first();
        if(Request()->getRequestUri('trx/create') && is_null($cek)){
            return redirect('trx');
        }

        $trx = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('status',0)
        ->latest()->first()->id;

        $menu = Menu::where('status','1')->get();
        return view('trx.index',compact(['menu','trx']));
    }

    public function invoice($id = 0,$last = false){
        if($last){
            $trx = Trx::find($id);
            $date = $trx->first()->created_at;
            $meja = Meja::whereIn('id',unserialize($trx->meja_id))->oldest()->get();
            $transaksi = $trx->detailTrx->where('trx_id',$id)->where('status_payment',1);
        }
        else{
            $idDetail = str_replace('-',',',$id);
            $detail = DetailTrx::whereIn('id',explode(",",$idDetail));
            $transaksi = $detail->get();

            $trxId = $detail->first()->trx_id;
            $trx = Trx::find($trxId);
            $date = $trx->first()->created_at;
            $meja = Meja::whereIn('id',unserialize($trx->meja_id))->oldest()->get();

        }


        foreach($transaksi as $key => $value){
            if($value->jenis == 'Single'){
                $transaksi[$key]['nama_jenis'] = Menu::where('id',$value->id_jenis)->first()->nama;
                $transaksi[$key]['harga'] = Menu::where('id',$value->id_jenis)->first()->harga;
            }else{
                $transaksi[$key]['nama_jenis'] = Paket::where('id',$value->id_jenis)->first()->nama;
                $transaksi[$key]['harga'] = Paket::where('id',$value->id_jenis)->first()->harga;
            }

        }


        return view('trx.invoice',compact('transaksi','meja','date'));
    }

    public function chooseTable(Request $request){
        $idMeja = serialize($request->idMeja);
        $idTrx = $request->trx_id;
        if($idTrx > 0){
            $trx = Trx::find($idTrx);
            $oldMeja =  $trx->meja_id;

            $upMeja = Meja::whereIn('id',unserialize($oldMeja))->update(['status' => 1]);
            if($upMeja){
                $trx->update(['meja_id' => $idMeja]);
                Meja::whereIn('id',unserialize($idMeja))->update(['status' => 0]);
            }

            return response()->json([
                'success' => 'Berhasil'
            ]);
        }
        else{
            Trx::create([
                'user_id' => auth()->user()->id,
                'meja_id' => $idMeja
            ]);

            for($i = 0; $i < count($request->idMeja); $i++){
                Meja::where('id',$request->idMeja[$i])->update(['status' => 0]);
            }

            return response()->json([
                'success' => 'Berhasil'
            ]);
        }


    }

    public function create(){
        $cek = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('status',0)
        ->latest()->first();
        if(Request()->getRequestUri('trx/create') && is_null($cek)){
            return redirect('trx');
        }

        $trx = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('status',0)
        ->latest()->first()->id;

        $menu = Menu::where('status','1')->get();
        return view('trx.index',compact(['menu','trx']));
    }

    public function store(Request $request){

        $total_payment = 0;

        for ($i=0; $i < count($request->menu); $i++) {
            $total_payment += $request->sub[$i];
        }

        $trx = Trx::where('id',$request->trx_id)->update(['total_payment' => $total_payment]);
        for ($i=0; $i < count($request->menu); $i++) {
            DetailTrx::create([
                'trx_id' => $request->trx_id,
                'jenis' => $request->jenis[$i],
                'id_jenis' => $request->menu[$i],
                'qty' => $request->qty[$i],
                'status_payment' => 0,
                'jenis_payment' => '',
            ]);
        }

        return redirect('trx')->with('success', 'Transaksi berhasil ditambahkan');

    }

    public function checkout($id = 0,Request $request){
        $trx= Trx::where('id',$id);
        $idMeja = $trx->first()->meja_id;

        if($trx->update(['status' => 1])){
            Meja::whereIn('id',unserialize($idMeja))->update(['status' => 1]);

            DetailTrx::where('trx_id',$id)->update(['status_payment' =>1,'jenis_payment' => $request->method]);

            return response()->json([
                'success' => true,
                'url' => route('invoice',$id)
            ]);
        }

    }

    public function splitBill($id = 0){
        $transaksi = Trx::find($id)->detailTrx->where('status_payment',0);
         foreach($transaksi as $key => $value){
             if($value->jenis == 'Single'){
                 $transaksi[$key]['nama_jenis'] = Menu::where('id',$value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Menu::where('id',$value->id_jenis)->first()->harga;
             }else{
                 $transaksi[$key]['nama_jenis'] = Paket::where('id',$value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Paket::where('id',$value->id_jenis)->first()->harga;
             }
         }

         return view('trx.split',compact('transaksi'));
     }

    public function pindahMeja($id = 0){
        $cek = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('total_payment',0)
        ->latest()->first();
        if(!empty($cek)){
            return redirect('trx/create');
        }

        $trx = Trx::find($id);
        $idMeja =  unserialize($trx->meja_id);
        $meja = Meja::where('status',1)->orWhere(function($query) use($idMeja) {
                $query->whereIn('id',$idMeja);
            })->oldest()->get();
        return view('trx.choose-table',compact('meja'));
    }

    public function cancel($id = 0){
        $trx = Trx::find($id);
        Meja::whereIn('id',unserialize($trx->meja_id))->update(['status' => 1]);
        $trx->delete();
        return redirect('trx')->with('success','Berhasil cancel pesanan');
    }

    public function splitSelected(Request $request)
    {
        $ids = $request->ids;
        $trx = DetailTrx::whereIn('id',explode(",",$ids))->update(['status_payment' => 1,'jenis_payment' => $request->method]);
        $getDTStatus = DetailTrx::whereIn('trx_id',[$request->trx_id]);
        $paidAll = $getDTStatus->sum('status_payment');
        $count = $getDTStatus->count();
        $response = [
            'success'=> 'berhasil',
            'url' => route('invoice',str_replace(',','-',$ids)),
        ];
        if($paidAll == $count){
            $trx = Trx::find($request->trx_id);
            Meja::whereIn('id',unserialize($trx->meja_id))->update(['status' => 1]);
            $trx->update(['status' => 1]);
            $response['url'] = route('invoice',str_replace(',','-',$ids));
            $response['paidAll'] = true;
        }

        return response()->json($response);
    }

    public function report(){
        $report = Trx::latest()->get();
        return view('trx.report',compact('report'));
    }

    public function orderPegawai(){
        $transaksi = Trx::where('user_id',auth()->user()->id)
        ->whereDate('created_at',date('Y-m-d'))
        ->orderBy('created_at','desc')->with('detailTrx')
        ->get();
        // return $transaksi;
         foreach($transaksi as $key => $row){
            $idMeja = $row->meja_id;
            $transaksi[$key]['meja'] = Meja::whereIn('id',unserialize($idMeja))->get();
        }
        foreach($transaksi as $key => $value){
            foreach($value->detailTrx as $k2 => $v2){
                if($v2->jenis == 'Single'){
                    $value->detailTrx[$k2]['harga'] = Menu::where('id',$v2->id_jenis)->first()->harga;
                }else{
                    $value->detailTrx[$k2]['harga'] = Paket::where('id',$v2->id_jenis)->first()->harga;
                }
            }
        }
        // return $transaksi;
        return view('trx.order-pegawai',compact('transaksi'));
    }

    public function listMenu($id = 0){
        $trx = Trx::find($id);
        $meja = Meja::whereIn('id',unserialize($trx->meja_id))->oldest()->get();
        $transaksi = Trx::with('detailTrx')->find($id)->detailTrx;

         foreach($transaksi as $key => $value){
             if($value->jenis == 'Single'){
                 $transaksi[$key]['nama_jenis'] = Menu::where('id',$value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Menu::where('id',$value->id_jenis)->first()->harga;
             }else{
                 $transaksi[$key]['nama_jenis'] = Paket::where('id',$value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Paket::where('id',$value->id_jenis)->first()->harga;
             }

         }

         return view('trx.order-detail',compact('transaksi','meja'));
     }

    public function bestSelling(){
        $best = DetailTrx::select('id_jenis')
        ->selectRaw('sum(qty) as jumlah')
        ->where('jenis','Single')->groupBy('id_jenis')->get();
        foreach($best as $key => $value){
            $best[$key]['nama_jenis'] = Menu::where('id',$value->id_jenis)->first()->nama;
        }
        return view('trx.best',compact('best'));
    }

    public function checkout(Request $request,$id){
        $trx= Trx::where('id',$id);
        $idMeja = $trx->first()->meja_id;

        if($trx->update(['status' => 1])){
            Meja::whereIn('id',unserialize($idMeja))->update(['status' => 1]);

            DetailTrx::where('trx_id',$id)->update(['status_payment' =>1,'jenis_payment' => $request->method]);

            return response()->json([
                'success' => true,
                'url' => route('invoice',$id)
            ]);
        }

    }
    public function splitBill($id = 0){
        $transaksi = Trx::with('detailTrx')->find($id)->detailTrx->where('status_payment',0);
         foreach($transaksi as $key => $value){
             if($value->jenis == 'Single'){
                 $transaksi[$key]['nama_jenis'] = Menu::where('id', $value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Menu::where('id', $value->id_jenis)->first()->harga;
             }else{
                 $transaksi[$key]['nama_jenis'] = Paket::where('id', $value->id_jenis)->first()->nama;
                 $transaksi[$key]['harga'] = Paket::where('id', $value->id_jenis)->first()->harga;
             }

         }

         return view('trx.split',compact('transaksi'));
     }

     public function pindahMeja($id = 0){
        $cek = Trx::where('user_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->where('total_payment',0)
        ->latest()->first();
        if(!empty($cek)){
            return redirect('trx/create');
        }

        $trx = Trx::find($id);
        $idMeja =  unserialize($trx->meja_id);
        $meja = Meja::where('status',1)->orWhere(function($query) use($idMeja) {
                $query->whereIn('id',$idMeja);
            })->oldest()->get();
        return view('trx.choose-table',compact('meja'));
    }

     public function cancel($id = 0){
        $trx = Trx::find($id);
        Meja::whereIn('id',unserialize($trx->meja_id))->update(['status' => 1]);
        $trx->delete();
        return redirect('trx')->with('success','Berhasil cancel pesanan');
    }

     public function splitSelected(Request $request)
     {
         $ids = $request->ids;
         DetailTrx::whereIn('id',explode(",",$ids))->update(['status_payment' => 1]);
         return response()->json(['success'=>"berhasil."]);
     }

     public function paymentReport(){
        $report = DetailTrx::latest()->get();
        foreach($report as $key => $value){
            if($value->jenis == 'Single'){
                $report[$key]['nama'] = Menu::where('id',$value->id_jenis)->first()->nama;
                $report[$key]['harga'] = Menu::where('id',$value->id_jenis)->first()->harga;
            }else{
                $report[$key]['nama'] = Paket::where('id',$value->id_jenis)->first()->nama;
                $report[$key]['harga'] = Paket::where('id',$value->id_jenis)->first()->harga;
            }

        }
        // return $report;
        return view('trx.payment-report',compact('report'));
    }

}
