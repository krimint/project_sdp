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

                        <!-- Jo -->
                        <form action="/trx/store" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Simpan</button>
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <tr>
                                    <th>Meja</th>
                                    <th>Jenis</th>
                                    <th>Menu</th>
                                    <th>Qty</th>
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
                                        <select class="form-control menu" name="menu[]" id="menu_1">@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach</select></td>
                                    </td>
                                    <td><input type="text" name="qty[]" class="form-control" placeholder="Qty"></td>
                                <td><button type="button" name="add" id="add-btn" class="btn btn-success">Add More</button></td>
                                </tr>
                            </table>
                        </form>
                        <!--  -->


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
                                        @if($value->status_payment == 0)
                                            <p>Menunggu</p>
                                            @else
                                            <p>Terbayar</p>
                                        @endif
                                    </td>
                                    <td>{{  $value->total_payment }}</td>
                                    <td>
                                    <a class="btn btn-primary btn-sm">Split Bill</a>
                                    <a class="btn btn-info btn-sm">Checkout</a>
                                    </td>
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
            var j = 0;
            // $('.jenis').on('change', function() {
            //    var jenis = $(this).val();
            //    if(jenis === 'Paket') {
            //        $.ajax({
            //            url: '/getPaket',
            //            type: "GET",
            //            data : {"_token":"{{ csrf_token() }}"},
            //            dataType: "json",
            //            success:function(data)
            //            {
            //                 if(data){
            //                     $('#menu').empty();
            //                     $('#menu').append('<option hidden>Pilih Paket</option>');
            //                     $.each(data, function(key, paket){
            //                         $('#menu').append('<option value="'+ key +'">' + paket.nama+ '</option>');
            //                     });
            //                 }
            //             }
            //         });
            //     ++j;
            //     }
            //     else{
            //         $('#menu').empty();
            //         $('#menu').append('@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach');
            //     }
            // });

            // $('.select2').select2()
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
                                    $('#menu_'+param).append('<option value="'+ key +'">' + paket.nama+ '</option>');
                                });
                            }
                        }
                    });
                }
                else{
                    $('#menu_'+param).empty();
                    $('#menu_'+param).append('@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach');
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
            '<td><select class="form-control menu" name="menu[]" id="menu_'+i+'">'+
            '@foreach($menu as $value)<option value="{{ $value->id }}">{{ $value->nama }}</option>@endforeach</select></td>'+
            '<td><input type="text" name="qty[]" class="form-control" placeholder="Qty"></td>'+
            '<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });
</script>
@endsection
