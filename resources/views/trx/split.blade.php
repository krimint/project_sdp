@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Split Bill</p>
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
                        <div class="float-right">
                            <button style="margin-bottom: 10px" class="btn btn-primary splitAll" data-url="{{ url('splitSelected') }}">Split All Selected</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50px"><input type="checkbox" id="master"></th>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi as $value)
                                    <tr id="tr_{{$value->id}}">
                                        <td>
                                            <input type="checkbox" class="sub_chk"
                                            data-id="{{$value->id}}" data-qty="{{ $value->qty }}" data-harga="{{ $value->harga }}">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->nama_jenis }}</td>
                                        <td>{{ $value->qty }}</td>
                                        <td>{{ 'Rp '.number_format($value->harga,0,',','.') }}</td>
                                        <td>
                                            @if ($value->status_payment == 1)
                                                Terbayar
                                                @else
                                                Menunggu
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->

    <div class="modal" id="splitBill">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title splitBill-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="splitBill-form">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">

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
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))
         {
            $(".sub_chk").prop('checked', true);
         } else {
            $(".sub_chk").prop('checked',false);
         }
        });

        $('.splitAll').on('click', function(e) {
            var allVals = [];
            var allQty = [];
            var allPrice = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
                allQty.push($(this).attr('data-qty'));
                allPrice.push($(this).attr('data-harga'));
            });
            if(allVals.length <=0)
            {
                alert("Please select row.");
            }
            else {
                var modal = $('#splitBill').modal();
                if(modal.show()){
                    $('.splitBill-title').html("Split Bill");
                    var trx_id = <?php echo Request::segment(2) ?>;
                    var arrQty = allQty;
                    var arrPrice = allPrice;
                    const produceAndAdd = (arrQty = [], arrPrice = []) => {
                        let sum = 0;
                        for(let i=0; i < arrQty.length; i++) {
                            const subTotal = (arrQty[i] * arrPrice[i]);
                            sum += subTotal;
                        };
                        return sum;
                    };
                    $('#total_payment').val(produceAndAdd(arrQty, arrPrice));
                    $('#btn-save').on('click', function(e) {
                        var join_selected_values = allVals.join(",");
                        var bayar = $('#jenis_payment').val();
                        var kembalian = $('#kembalian').val()
                        if(kembalian == '' || kembalian < 0){
                            alert('Jumlah bayar kurang');
                        }
                        else{
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                type: 'PUT',
                                url: '<?php echo url('splitSelected'); ?>',
                                data: {
                                    'ids':join_selected_values,
                                    'trx_id': trx_id,
                                    'method':bayar
                                    },
                                success: function (data) {
                                    if(data['url']){
                                        window.location.href = data.url;
                                    }
                                    else{
                                        if (data['success']) {
                                            $(".sub_chk:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            alert(data['success']);
                                            $('#splitBill-form')[0].reset();

                                            $('#splitBill').modal('hide');
                                        } else if (data['error']) {
                                            alert(data['error']);
                                        } else {
                                            alert('Whoops Something went wrong!!');
                                        }
                                    }
                                },
                                error: function (data) {
                                    alert(data.responseText);
                                }
                            });
                            $.each(allVals, function( index, value ) {
                                $('table tr').filter("[data-row-id='" + value + "']").remove();
                            });
                        }

                    });

                }
            }
        });
        // $('[data-toggle=confirmation]').confirmation({
        //     rootSelector: '[data-toggle=confirmation]',
        //     onConfirm: function (event, element) {
        //         element.trigger('confirm');
        //     }
        // });
        // $(document).on('confirm', function (e) {
        //     var ele = e.target;
        //     e.preventDefault();
        //     $.ajax({
        //         url: ele.href,
        //         type: 'DELETE',
        //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         success: function (data) {
        //             if (data['success']) {
        //                 $("#" + data['tr']).slideUp("slow");
        //                 alert(data['success']);
        //             } else if (data['error']) {
        //                 alert(data['error']);
        //             } else {
        //                 alert('Whoops Something went wrong!!');
        //             }
        //         },
        //         error: function (data) {
        //             alert(data.responseText);
        //         }
        //     });
        //     return false;
        // });
    });
</script>

<script type="text/javascript">
    function totalBayar(){
        var harga = document.getElementById('total_payment').value;
        var bayar = document.getElementById('total_bayar').value;

        var tB = parseFloat(bayar) - parseFloat(harga);
        document.getElementById('kembalian').value = tB;
    }
</script>
@endsection
