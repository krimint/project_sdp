@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Order Detail
                        
                        @foreach ($meja as $key => $item)
                            <span class="font-weight-bold">{{ $item->nama }}</span>
                        @endforeach</p>
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
                        <table class="table table-bordered" id="report-table">
                            <thead>
                                <th>No</th>
                                <th>Pesanan</th>
                                <th>Qty</th>
                                <th>Jenis Pembayaran</th>
                                <th>Tanggal</th>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $value)
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td>{{  $value->nama_jenis }}</td>
                                    <td>{{  $value->qty }}</td>
                                    <td>{{ $value->jenis_payment }}</td> 
                                    <td>{{ $value->created_at->format('D d M Y H:i') }} WIB</td>
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
            var table = $('#report-table').DataTable({
                processing:true
            });    
        });
    </script>
@endsection