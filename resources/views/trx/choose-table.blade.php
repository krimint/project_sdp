@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row justify-content-end mb-3 mr-5">
            <div class="">
                <?php
                    $verify =  Request::segment(3);
                ?>
                <button type="button" class="btn btn-dark" id="order"><?= ($verify == 'pindahMeja') ? 'Save' : 'Order' ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @foreach ($meja as $value)
                        <div class="col-md-4">
                            <div class="card shadow-rounded text-center bg-<?= ($value->status == 1) ? 'success' : 'danger' ?>" data-id="{{ $value->id }}">
                                <div class="card-body">
                                    <p class="card-text">{{ $value->nama }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> 
        </div>
    </section>        
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var allMeja = [];
            var verify = '<?php echo Request::segment(3) ?>';
            $('.card').on('click',function(){
                if(verify === 'pindahMeja'){
                    $(this).removeClass('bg-danger');
                }
                $(this).removeClass('bg-success');
                $(this).addClass('bg-info');
                allMeja.push($(this).attr('data-id'));
            });
            $('#order').on('click',function(){
                if(allMeja.length <= 0){
                    alert('Please select table before order');
                }
                else{
                    var trxId = 0;
                    if(verify === 'pindahMeja'){
                        trxId = '<?php echo Request::segment(2) ?>';
                    }
                    $.ajax({
                        url: '<?php echo route("chooseTable"); ?>',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            'idMeja':allMeja,
                            'trx_id': trxId,
                            },
                        success: function (data) {
                            if (data['success']) {
                                alert(data['success']);
                                if(trxId > 0){
                                    window.location.href = '<?php echo route("orderPegawai") ?>';
                                }
                                else{
                                    window.location.href = '<?php echo route("trxcreate") ?>';
                                }
                                
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                }
                
            });
        });
    </script>
@endsection