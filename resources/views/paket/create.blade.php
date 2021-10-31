@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Tambah Paket</p>
                        <a class="btn btn-danger float-right" href="/paket">Kembali</a>
                    </div>
                    <div class="card-body">
                         @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="/paket" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="ex: Super Hemat" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ketersediaan</label>
                                <select name="status" class="form-control" required>
                                    <option value="0">Tidak tersedia</option>
                                    <option value="1">Tersedia</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" placeholder="ex: 10000" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>        
        </div>
    </section>
    <!-- /.content -->


@endsection 

@section('script')
    
@endsection