@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Payment Report</p>
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
                        <?php
                            $method = [];
                            foreach($report as $key => $value){
                                $method[$value->jenis_payment][] = $value->qty*$value->harga;
                            }
                        ?>

                        <table class="table table-bordered" id="report-table">
                            <thead>
                                <th>No</th>
                                <th>Jenis Pembayaran</th>
                                <th>Total Pendapatan</th>
                            </thead>
                            <tbody>
                                @php
                                    // dd($method);
                                @endphp
                                @foreach ($method as $key2 => $val)
                                <tr>
                                     <td>{{ $loop->iteration }}</td>
                                    <td>{{ $key2 }}</td>
                                    <td>{{ 'Rp '.number_format(array_sum($val),0,',','.') }}</td>
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
