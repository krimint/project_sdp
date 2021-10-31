@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Dashboard</p>
                    </div>
                    <div class="card-body">
                       Selamat datang {{ Auth::user()->name }}
                    </div>
                </div>
            </div>        
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')

@endsection