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
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$value->id}}"></td>
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
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if(allVals.length <=0)
            {
                alert("Please select row.");
            }  else {
                var check = confirm("Apakah anda yakin?");
                if(check == true){
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'PUT',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
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
@endsection
