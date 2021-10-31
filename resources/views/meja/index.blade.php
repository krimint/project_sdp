@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Meja</p>
                        <!-- <a class="btn btn-success float-right" id="add">Add</a> -->
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="meja-table">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <!-- <th>Aksi</th> -->
                            </thead>
                            <tbody>
                                @foreach ($mejas as $value)
                                <tr>
                                    <td>{{  $value->id }}</td>
                                    <td>{{  $value->nama    }}</td>
                                    <td>
                                        @if($value->status == 0)
                                            <p>Tidak tersedia</p>
                                            @else
                                            <p>Tersedia</p>    
                                        @endif 
                                    </td>
                                    <!-- <td>
                                        <a data-toggle="tooltip"  data-id="{{ $value->id }}" data-original-title="Edit" class="edit btn btn-warning btn-sm editMenu">Edit</a>
                                        <a class="btn btn-danger btn-sm text-white deleteMenu"  data-id="{{ $value->id }}">Delete</a>
                                    </td> -->
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

    <!-- Modal Add -->
    <!-- <div class="modal fade" id="modalMenu" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalMenu" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menu-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="menu-form" name="menu-form" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Ketersediaan</label>
                         <select class="form-control" name="status" id="status">
                            <option value="0">Tidak Tersedia</option>
                            <option value="1">Tersedia</option>
                        </select>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div> -->

@endsection 

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            var table = $('#meja-table').DataTable({
                processing:true
            });    

            // $('#add').click(function () {
            //     $('#saveBtn').val("create-menu");
            //     $('#id').val('');
            //     $('#menu-form').trigger("reset");
            //     $('#menu-title').html("Tambah Menu");
            //     $('#modalMenu').modal('show');
            // });

            // $('body').on('click', '.editMenu', function () {
            //     var id = $(this).data('id');
            //     $.get("" +'/menu/' + id +'/edit', function (data) {
            //         $('#menu-title').html("Edit Menu");
            //         $('#saveBtn').val("edit-menu");
            //         $('#modalMenu').modal('show');
            //         $('#id').val(data.id);
            //         $('#nama').val(data.nama);
            //         $('#kategori').val(data.kategori);
            //         $('#harga').val(data.harga);
            //         $('#status').val(data.status);
            //     })
            // });

            // $('#saveBtn').click(function (e) {
            //     e.preventDefault();
            //     $(this).html('Sending..');
               
            //     $.ajax({
            //         data: $('#menu-form').serialize(),
            //         url: "",
            //         type: "POST",
            //         dataType: 'json',
            //         success: function (data) {
            //             $('#menu-form').trigger("reset");
            //             $('#modalMenu').modal('hide');
            //             location.reload();
            //         },
            //         error: function (data) {
            //             console.log('Error:', data);
            //             $('#saveBtn').html('Save Changes');
            //         }
            //     });
            // });

            // $('body').on('click', '.deleteMenu', function () {

            //     var id = $(this).data("id");
            //     confirm("Are You sure want to delete !");

            //     $.ajax({
            //         type: "DELETE",
            //         url: "menu/"+id,
            //         success: function (data) {
            //             location.reload();
            //         },
            //         error: function (data) {
            //             console.log('Error:', data);
            //         }
            //     });
            // });

        }); 

           
    </script>
@endsection