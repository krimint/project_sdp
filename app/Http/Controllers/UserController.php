<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $posts = User::latest()->paginate(6);

        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 6);
    }
    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'role' => 'required',
            'active' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('posts.index')
                        ->with('success','Pegawai Created Successfully.');
    }
    public function show(User $post)
    {
        return view('posts.show',compact('post'));
    }

    public function edit(User $post)
    {
        return view('posts.edit',compact('post'));
    }

    public function update(Request $request, User $post)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'role' => 'required',
            'active' => 'required',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
                        ->with('success','Pegawai Updated Successfully');
    }

    public function destroy(User $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success','Pegawai Deleted Successfully');
    }
}
