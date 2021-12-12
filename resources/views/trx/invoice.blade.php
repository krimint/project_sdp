@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12 p-3">
                <div class="card border-0 p-4 p-md-5 rounded">
                    <div class="card-header border-0">
                        <h1 class="text-center">Restoran</h1>
                    </div>
                    <div class="text-left">
                        <h5 class="text-center">Invoice #@foreach ($meja as $key => $item)
                            <span class="font-weight-bold">{{ $item->nama }}</span>
                        @endforeach</h5>
                    </div>
                    <div class="text-right">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item font-weight-bold">Sales : {{ Auth::user()->name }}</li>
                            <li class="list-group-item font-weight-bold">{{ $date->format('l, d F Y') }}</li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    @foreach($transaksi as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->nama_jenis }}</td>
                                        <td>{{ $value->qty }}</td>
                                        <td>{{ 'Rp '.number_format($value->harga,0,',','.') }}</td>
                                        <td>{{ 'Rp '.number_format(($value->harga*$value->qty),0,',','.') }}</td>
                                    </tr>
                                    @php
                                        $total += $value->qty*$value->harga;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item font-weight-bold">{{ 'Rp '.number_format($total,0,',','.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
