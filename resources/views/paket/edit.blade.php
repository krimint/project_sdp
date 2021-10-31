@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Edit Paket</p>
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
                        <form action="{{ route('paket.update', $paket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ $paket->nama }}" placeholder="ex: Sate" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ketersediaan</label>
                                <select name="status" class="form-control">
                                    <option value="0">Tidak tersedia</option>
                                    <option value="1">Tersedia</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" value="{{ $paket->harga }}" placeholder="ex: 1000" required>
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