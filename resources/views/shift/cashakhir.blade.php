@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Tambah Cash Akhir</p>
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
                        <form action="/storeakhir" method="POST">
                        @csrf
                        <div class="form-row">
                        <input type="hidden" name="id" value="{{ $cek->id }}">
                            <div class="form-group col-md-4">
                                <label>Cash Akhir</label>
                                <input type="number" name="cash_akhir" class="form-control" placeholder="ex: 10000" required>
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
