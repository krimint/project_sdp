@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Pegawai Report</p>
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
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                                <th>Total Pendapatan</th>
                            </thead>
                            <tbody>
                                @foreach ($report as $value)
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td>{{  $value->name }}</td>
                                    <td>{{  $value->created_at->format('d M Y') }}</td>
                                    <td>{{ 'Rp '.number_format($value->total,0,',','.') }}</td>
                                   
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