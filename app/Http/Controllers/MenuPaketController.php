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

    // public function create(){
    //     return view('paket.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string',
    //         'status' => 'required',
    //         'harga' => 'required|numeric'
    //     ]);
        
    //     Paket::create($request->all());
    //     return redirect('paket')->with('success', 'Paket berhasil ditambahkan');
    // }

    // public function edit(Paket $paket)
    // {
    //     return view('paket.edit', compact('paket'));
    // }

    // public function update(Request $request, Paket $paket){
    //     $request->validate([
    //         'nama' => 'required|string',
    //         'status' => 'required',
    //         'harga' => 'required|numeric'
    //     ]);

    //     $paket->update($request->all());
    //     return redirect()->route('paket.index')->with('success','Paket berhasil diupdate!');
       
    // }

    // public function destroy(Paket $paket)
    // {
    //     $paket->delete();

    //     return redirect('paket')->with('success','Paket berhasil dihapus');
    // }
}
