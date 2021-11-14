@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Pegawai</p>
                        <a class="btn btn-success float-right" href="/posts/create">Add</a>
                    </div>
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table class="table table-bordered" id="paket-table">
                            <thead>
                                <th width="20px" class="text-center">No</th>
                                <th width="280px"class="text-center">Nama</th>
                                <th width="280px"class="text-center">Email</th>
                                <th width="170px"class="text-center">Jenis Kelamin</th>
                                <th width="240px"class="text-center">Tanggal Lahir</th>
                                <th>Role</th>
                                <th width="200px"class="text-center">Status</th>
                                <th width="400px"class="text-center">Action</th>
                            </thead>
                            <tbody>
                               @foreach ($posts as $user)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->jenis_kelamin }}</td>
                                    <td>{{ $user->tanggal_lahir }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->active }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('posts.destroy',$user->id) }}" method="POST" class="form-inline">
                                            <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$user->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#paket-table').DataTable({
                processing:true
            });
        });
    </script>
@endsection
