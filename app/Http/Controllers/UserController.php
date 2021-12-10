<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|unique:users',
            'image' => 'image|required|max:10240',
            'password' => 'required|string|min:4',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'role' => 'required',
            'active' => 'required'
        ]);
        $input = $request->except('image');
        $input['password'] = Hash::make($input['password']);
        $create = User::create($input);
        if ($create) {
            $path = 'image/pengguna';
            $namafile = $create->email.".jpg";
            $request->file('image')->storeAs($path,$namafile,'public');

            // $fileName = date('YmdH:i:s').'.'.$image->getClientOriginalExtension();
            // $image->move($path, $fileName);
            // $input['image'] = $fileName;
        }


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
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$post->id.'',
            'image' => 'image|required|max:10240',
            'password' => 'nullable|string|min:4',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'role' => 'required',
            'active' => 'required',
        ]);
        $input = $validated;
        $input['password'] = Hash::make($input['password']);

        $post->update($input);

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
