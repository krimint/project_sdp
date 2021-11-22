@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Transaksi</p>
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="/trx/store" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Simpan</button>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamicAddRemove">
                                    <tr>
                                        <th>Meja</th>
                                        <th>Jenis</th>
                                        <th>Menu</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="meja[]">
                                                @foreach($meja as $value)
                                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control jenis" name="jenis[]" id="jenis_1" onchange="dynamics(1)">
                                                <option value="Single">Single</option>
                                                <option value="Paket">Paket</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control menu" name="menu[]" id="menu_1" onchange="showHarga(1)"><option disabled selected>Pilih Menu</option>@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach</select></td>
                                        </td>
                                        <td><input type="text" name="qty[]" id="qty_1" onchange="calcSub(1)" class="form-control" placeholder="Qty" readonly></td>
                                        <td><input type="text" name="harga[]" id="harga_1" class="form-control" placeholder="Harga" readonly></td>
                                        <td><input type="text" name="sub[]" id="sub_1" class="form-control" placeholder="Sub Total" readonly></td>
                                    <td><button type="button" name="add" id="add-btn" class="btn btn-sm btn-success">Add</button></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">List Transaksi</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="transaksi-table">
                                <thead>
                                    <th>No</th>
                                    <th>Meja</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->nama_meja }}</td>
                                        <td>
                                            @if($value->status == 0)
                                                <p>Menunggu</p>
                                                @else
                                                <p>Terbayar</p>
                                            @endif
                                        </td>
                                        <td>{{ 'Rp '.number_format($value->total_payment,0,',','.') }}</td>
                                        <td>
                                            <a onclick="checkout({{$value->id}})" id="{{$value->id}}" data-meja="{{$value->meja_id}}" data-total="{{$value->total_payment}}" class="btn btn-primary btn-sm">Checkout</a>
                                            <a href="#" class="btn btn-info btn-sm">Split Bill</a>
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
                                                    <input type="hidden" name="id" id="id">
                                                    <input type="hidden" name="meja" id="meja">
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
                                                    <input type="text" class="form-control"  id="total_bayar" name="total_bayar" onchange="totalBayar()" required>
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
        var table = $('#transaksi-table').DataTable({
            processing:true
        });
    });

    function dynamics(param = 1){
        var jenis = document.getElementById('jenis_'+param).value;
        // alert(jenis);
            if(jenis === 'Paket') {
                $.ajax({
                    url: '/getPaket',
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data)
                    {
                        if(data){
                            $('#menu_'+param).empty();
                            $('#menu_'+param).append('<option hidden>Pilih Paket</option>');
                            $.each(data, function(key, paket){
                                $('#menu_'+param).append('<option value="'+ paket.id +'">' + paket.nama+ '</option>');
                            });
                        }
                    }
                });
            }
            else{
                $('#menu_'+param).empty();
                $('#menu_'+param).append('<option disabled selected>Pilih Menu</option>@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach');
            }
    }
</script>

<script type="text/javascript">
    var i = 1;
    $("#add-btn").click(function(){
         ++i;
        $("#dynamicAddRemove").append(
            '<tr><td>-</td>'+
            '<td><select class="form-control jenis" name="jenis[]" id="jenis_'+i+'" onchange="dynamics('+i+')">'+
            '<option value="Single">Single</option><option value="Paket">Paket</option></select></td>'+
            '<td><select class="form-control menu" name="menu[]" id="menu_'+i+'" onchange="showHarga('+i+')">'+
            '<option disabled selected>Pilih Menu</option>@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach</select></td>'+
            '<td><input type="text" name="qty[]" id="qty_'+i+'" class="form-control" placeholder="Qty" onchange="calcSub('+i+')" readonly></td>'+
            '<td><input type="text" name="harga[]" id="harga_'+i+'" class="form-control" placeholder="Harga" readonly></td>'+
            '<td><input type="text" name="sub[]" id="sub_'+i+'" class="form-control" placeholder="Sub Total" readonly></td>'+
            '<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });
</script>

<script type="text/javascript">

    function showHarga(param = 1){
        var menu = document.getElementById('menu_'+param).value;
        var jenis = document.getElementById('jenis_'+param).value;
        var url = '';
        if(jenis === 'Single'){
            url = '/hargaMenu';
        }
        else if(jenis === 'Paket'){
            url = '/hargaPaket';

        }
        $.ajax({
            url: url,
            type: 'GET',
            data : {
                "_token":"{{ csrf_token() }}",
                "id": menu,
                },
            dataType: 'json',
            success: function(response){
                if(response != null){
                    $('#qty_'+param).removeAttr('readonly');
                    $('#harga_'+param).val(response.harga);
                }
            }
        });
    }

    function calcSub(row = 1){
        var menu = document.getElementById('menu_'+row);
        var qty = document.getElementById('qty_'+row).value;
        var price = document.getElementById('harga_'+row).value;

            var calculate = parseFloat(qty) * parseFloat(price);
            document.getElementById('sub_'+row).value = calculate;

    }
</script>

<script>
    function checkout(id){
        var total = $('#'+id).data('total');
        var meja = $('#'+id).data('meja');
        $('.checkout-title').html("Checkout");
        $('#checkout').modal('show');
        $('#total_payment').val(total);
        $('#id').val(id);
        $('#meja').val(meja);
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
            var id = $('#id').val();
            var meja = $('#meja').val();
            var bayar = $('#total-bayar').val();
            var method = $('#jenis_payment').val();
            $.ajax({
                type:'POST',
                url: '/trx/'+id+'/checkout',
                data:{
                    "_token":"{{ csrf_token() }}",
                    "id": id,
                    'meja': meja,
                    "bayar": bayar,
                    "method": method,
                },
                success: (response) => {
                    $('#checkout').modal('hide');
                    $('#checkout-form').trigger("reset");
                },
            });
        });
   });
</script>
@endsection
