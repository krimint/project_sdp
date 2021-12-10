@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Activity Report</p>
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
                        <table class="table table-sm table-bordered" id="report-table">
                            <thead>
                                <th scope="row">No</th>
                                <th>Nama Pegawai</th>
                                <th>Shift Start</th>
                                <th>Shift End</th>
                                <th>Cash Awal</th>
                                <th>Cash Akhir</th>
                            </thead>
                            <tbody>
                                @foreach ($activity as $value)
                                <tr scope="row">
                                    <td>{{  $loop->iteration }}</td>
                                    <td>{{ $value->user->name}}</td>
                                    <td>{{ $value->waktu_awal->format('d F Y H:i') }}</td>
                                    <td>{{ $value->waktu_akhir->format('d F Y H:i') }}</td>
                                    <td><span class="badge badge-success">{{ 'Rp '.number_format($value->cash_awal,0,',','.') }}</span></td>
                                    <td><span class="badge badge-info">{{ 'Rp '.number_format($value->cash_akhir,0,',','.') }}</span></td>
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
