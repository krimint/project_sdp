@extends('layouts.app')

@section('content')


    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Data Pegawai</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}"> Tambah Pegawai</a>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </nav>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <table class="table table-bordered">

        <tr>
            <th width="20px" class="text-center">No</th>
            <th width="280px"class="text-center">Nama</th>
            <th width="280px"class="text-center">Email</th>
            <th width="170px"class="text-center">Jenis Kelamin</th>
            <th width="240px"class="text-center">Tanggal Lahir</th>
            <th>Role</th>
            <th width="200px"class="text-center">Status</th>
            <th width="280px"class="text-center">Action</th>
        </tr>

        @foreach ($posts as $user)
        <tr>
            <td class="text-center">{{ ++$i }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->jenis_kelamin }}</td>
            <td>{{ $user->tanggal_lahir }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->status }}</td>
            <td class="text-center">
                <form action="{{ route('posts.destroy',$user->id) }}" method="POST">

                    <a class="btn btn-info btn-sm" href="{{ route('posts.show',$user->id) }}">Show</a>

                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$user->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $posts->links() !!}
@endsection


