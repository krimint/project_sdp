<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Menu;
use App\Models\MenuPaket;
use Illuminate\Database\Eloquent\Builder;
class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();
        return view('paket.index',compact('pakets'));
    }

    public function create(){
        return view('paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:pakets',
            'status' => 'required',
            'harga' => 'required|numeric'
        ]);
        
        Paket::create($request->all());
        return redirect('paket')->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit(Paket $paket)
    {
        return view('paket.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket){
        $request->validate([
            'nama' => 'required|string|unique:pakets,'.$paket->id.'',
            'status' => 'required',
            'harga' => 'required|numeric'
        ]);

        $paket->update($request->all());
        return redirect()->route('paket.index')->with('success','Paket berhasil diupdate!');
       
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();

        return redirect('paket')->with('success','Paket berhasil dihapus');
    }

    public function getMenu($id){
        $paket = Paket::find($id);
        $menu = Menu::whereDoesntHave('paket', function (Builder $query) {
            $query->where('status', 1);
        })->get();
        $idPaket = $id;
        return view('paket.menu',compact('paket','idPaket','menu'));
    }

    public function addMenu(Request $request,$id){
        $paket = Paket::find($id);
        $paket->menu()->attach($request->menu);
        // for ($i=0; $i < count($request->menu); $i++) {
        //     $paket->menu()->attach($request->menu[$i]);
        // }
        return redirect('paket/'.$id.'/getMenu')->with('success','Berhasil');
    }

    public function deleteMenu($id,$id2){
        $menu = Menu::find($id);
        $menu->paket()->detach($id2);
        return redirect('paket/'.$id2.'/getMenu')->with('success','Yeah');
    }
}
