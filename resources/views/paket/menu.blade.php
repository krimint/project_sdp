@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Menu Paket</p>
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
                        <form action="/paket/{{ $idPaket }}/addMenu" method="post" class="col-md-6">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Simpan</button>
                            <table class="table table-borderless" id="menu-table">
                                <tr>
                                    <th>Menu</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" name="menu" required>
                                            @foreach($menu as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="qty" class="form-control" min="1" placeholder="ex: 1" required>
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <table class="table table-bordered" id="menupaket-table">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($paket->menu as $value)
                                <tr>
                                    <td>{{  $value->id }}</td>
                                    <td>{{  $value->nama }}</td>
                                    <td>{{  $value->kategori }}</td>
                                    <td>{{  $value->pivot->qty }}</td>
                                    <td>{{  $value->harga }}</td>
                                    <td>
                                        @if($value->status == 0)
                                            <p>Tidak tersedia</p>
                                            @else
                                            <p>Tersedia</p>    
                                        @endif 
                                    </td>
                                    
                                    <td>
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="/paket/{{ $value->id }}/{{ $idPaket }}/deleteMenu" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
            var table = $('#menupaket-table').DataTable({
                processing:true
            });    
        });
    </script>
@endsection