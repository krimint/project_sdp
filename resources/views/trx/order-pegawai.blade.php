@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">List Order</p>
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
                                <th>Tanggal</th>
                                <th>Total Pendapatan</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($report as $value)
                                <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td>{{  $value->created_at->format('d F Y') .' Jam '.$value->created_at->format('H:i')  }}</td>
                                    <td>{{ 'Rp '.number_format($value->total_payment,0,',','.') }}</td>
                                    <td>
                                        <a href="/trx/{{ $value->id }}/menu" class="btn btn-dark btn-sm">List Menu</a>
                                        @if ($value->status == 1)
                                            <a href="/trx/{{ $value->id }}/invoice" class="btn btn-primary btn-sm">Cetak Invoice</a>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">List Order</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" id="transaksi-table">
                                <thead>
                                    <th>No</th>
                                    <th>Meja</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th>Jam</th>
                                    <th>Action 1</th>
                                    <th>Action 2</th>
                                </thead>
                                <tbody>

                                    @foreach ($transaksi as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($value->meja as $key => $val2)
                                            {{ $val2->nama }}
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($value->status == 0)
                                                <p>Menunggu</p>
                                                @else
                                                <p>Terbayar</p>
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                                $menuPrice = 0;
                                                $total = 0;
                                            ?>
                                            @foreach ($value->detailTrx as $k2 => $v2)
                                                @php
                                                    if($value->status == 1){
                                                        $menuPrice = $value->total_payment;
                                                    }
                                                    $total = $value->total_payment;
                                                    if($v2->status_payment == 0){
                                                        $menuPrice += ($v2->harga*$v2->qty);
                                                    }
                                                    else{
                                                        if($v2->status_payment == 1){
                                                            $total = $total-$menuPrice;
                                                        }
                                                    }
                                               @endphp

                                            @endforeach
                                            {{ 'Rp '.number_format($menuPrice,0,',','.') }}
                                        </td>
                                        {{-- <td>{{ 'Rp '.number_format($value->total_payment,0,',','.') }}</td> --}}
                                        <td>{{ $value->created_at->format('H:i') }}</td>
                                        <td>
                                            @if($value->total_payment < 0 || $value->status != 1)
                                                <form class="d-inline" onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('cancel', $value->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>

                                                <a onclick="checkout({{ $value->id }})" id="{{$value->id}}" data-detail="{{ $value->detailTrx->where('status_payment',0)->pluck('id') }}" data-total="{{$menuPrice}}" class="btn btn-primary btn-sm">Checkout</a>
                                                <a href="{{ route('splitBill',$value->id) }}" class="btn btn-info btn-sm">Split Bill</a>
                                                <a href="{{ route('pindahMeja',$value->id) }}" class="btn btn-warning btn-sm">Pindah Meja</a>
                                            @endif
                                        </form>
                                        </td>
                                        <td>
                                            <a href="/trx/{{ $value->id }}/menu" class="btn btn-dark btn-sm">Menu</a>
                                            @if ($value->status == 1)
                                                <a href="/trx/{{ $value->id }}/invoice/true" class="btn btn-primary btn-sm">Invoice</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="modal" id="checkout">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title checkout-title"></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="checkout-form">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="hidden" name="trx_id" id="trx_id">
                                                    <input type="hidden" name="detail_id" id="detail_id">
                                                    <label for="total_payment" class="col-form-label">Total Harga:</label>
                                                    <input type="text" class="form-control" id="total_payment" name="total_payment" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jenis_payment" class="col-form-label">Jenis Pembayaran:</label>
                                                        <select class="form-control" name="jenis_payment" id="jenis_payment">
                                                            <option value="Cash">Cash</option>
                                                            <option value="Debit">Debit</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="total_bayar" class="col-form-label">Total Bayar:</label>
                                                    <input type="text" class="form-control" id="total_bayar" name="total_bayar" required onchange="totalBayar()">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kembalian" class="col-form-label">Kembalian:</label>
                                                    <input type="text" class="form-control" id="kembalian" name="kembalian" required readonly>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn btn-primary" id="btn-save">Save
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
        var table = $('#transaksi-table').DataTable({
            processing:true
        });
    });
    </script>
    <script>
    function checkout(id){
        var total = $('#'+id).data('total');
        var detail_id =  $('#'+id).data('detail');
        $('.checkout-title').html("Checkout");
        $('#checkout').modal('show');
        $('#total_payment').val(total);
        $('#trx_id').val(id);
        $('#detail_id').val(detail_id);
    }

    function totalBayar(){
        var harga = document.getElementById('total_payment').value;
        var bayar = document.getElementById('total_bayar').value;

        var tB = parseFloat(bayar) - parseFloat(harga);
        document.getElementById('kembalian').value = tB;
    }
</script>

<script>
   $(document).ready(function(){
        $('#btn-save').click(function(e) {
            e.preventDefault();
            var trx_id = $('#trx_id').val();
            var detail_id = $('#detail_id').val();
            var meja = $('#meja').val();
            var totalP = $('#total_payment').val();
            var method = $('#jenis_payment').val();
            var kembalian = $('#kembalian').val()
            if(kembalian == '' || kembalian < 0){
                alert('Jumlah bayar kurang');
            }
            else{
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "PUT",
                    url: "{{ url('checkout') }}",
                    data:{
                        "trx_id": trx_id,
                        "detail_id": detail_id,
                        "totalP": totalP,
                        "method": method,
                    },
                    success: (response) => {
                        if(response['url']){
                            window.location.href = response.url;
                        }
                        $('#checkout').modal('hide');
                        $('#checkout-form').trigger("reset");
                    },
                });
            }

        });
   });
</script>
@endsection
