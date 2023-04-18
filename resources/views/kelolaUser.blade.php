@extends('adminlte::page')

@section('title', 'Kelola User')

@section('content_header')
    <h1>Kelola User</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <!-- <th>Password</th> -->
                                    <th>Roles</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($user as $u)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <!-- <td>{{ $u->password }}</td> -->
                                        <td>{{ $u->roles->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="btn-ubah" class="btn btn-success" 
                                                    data-toggle="modal" data-target="#ubahUserModal" data-id="{{ $u->id }}">
                                                    Ubah
                                                </button>
                                                <button type="button" id="btn-hapus" class="btn btn-danger" data-toggle="modal" 
                                                    data-target="#hapusUserModal" data-id="{{ $u->id }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- M O D A L -->
<!-- Update/Edit Data -->
<div class="modal fade" id="ubahUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahUserModal">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('prodi.kelolaUser.ubah') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ubah-nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="ubah-nama" readonly="readonly" required/>
                                </div>
                                <div class="form-group">
                                    <label for="ubah-email">Email</label>
                                    <input type="text" class="form-control" name="email" id="ubah-email" readonly="readonly" required/>
                                </div>
                                <div class="form-group">
                                    <label for="ubah-password">Password</label>
                                    <input type="password" class="form-control" name="password" id="ubah-password" required/>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <!-- hidden --]> memerlukan id untuk mengubah data-nya -->
                <input type="hidden" name="id" id="ubah-id"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hapus Data -->
<div class="modal fade" id="hapusUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusUserModal">
                    Hapus Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda Yakin Ingin Mengapus Data <strong><span id="caption"></span></strong>?
                <form method="post" action="{{ route('prodi.kelolaUser.hapus') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>

                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
        $(function(){
            $(document).on('click', '#btn-ubah', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/prodi/ajaxprodi/dataUser/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#ubah-email').val(res.email);
                        $('#ubah-nama').val(res.name);
                        $('#ubah-password').val(res.password);
                        $('#ubah-id').val(res.id);
                    },
                });
            }); 
        });
    </script>

    <script>
        $(document).on('click', '#btn-hapus', function(){
                let id = $(this).data('id');
                let name = $(this).data('nama');

                $('#delete-id').val(id);
                $('#caption').text(name);
            });
    </script>
@stop