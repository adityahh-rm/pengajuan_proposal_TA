@extends('adminlte::page')

@section('title', 'Kelola Dosen')

@section('content_header')
    <h1>Kelola Dosen</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-success float-left" data-toggle="modal" data-target="#tambahDosenModal">
                            <i class="fa fa-plus"></i>
                            Tambah
                        </button>
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIDN</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($dosen as $ds)
                                    @if($ds->status == 1)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $ds->nama }}</td>
                                        <td>{{ $ds->nidn }}</td>
                                        <td>{{ $ds->email }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="btn-ubah" class="btn btn-success" 
                                                    data-toggle="modal" data-target="#ubahDosenModal" data-id="{{ $ds->id }}">
                                                    Ubah
                                                </button>
                                                <button type="button" id="btn-hapus" class="btn btn-danger" data-toggle="modal" 
                                                    data-target="#hapusDosenModal" data-id="{{ $ds->id }}" data-name="{{ $ds->nama }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- M O D A L -->
<!-- Proses Input Data Dosen -->
<div  class="modal fade" id="tambahDosenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDosenModal">
                    Tambah Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('prodi.kelolaDosen.tambah') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" name="nidn" id="nidn" required/>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" required/>
                        </div> 
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" required/>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit"  value="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>     
        </div>
    </div>
</div>

<!-- Update/Edit Data -->
<div class="modal fade" id="ubahDosenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahDosenModal">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('prodi.kelolaDosen.ubah') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ubah-nidn">NIDN</label>
                                    <input type="text" class="form-control" name="nidn" id="ubah-nidn" readonly="readonly" required/>
                                </div>
                                <div class="form-group">
                                    <label for="ubah-email">Email</label>
                                    <input type="text" class="form-control" name="email" id="ubah-email" required/>
                                </div>
                                <div class="form-group">
                                    <label for="ubah-nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="ubah-nama" required/>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="ubah-id"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hapus Data -->
<div class="modal fade" id="hapusDosenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusDosenModal">
                    Hapus Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda Yakin Ingin Mengapus Data <strong><span id="caption"></span></strong>?
                <form method="post" action="{{ route('prodi.kelolaDosen.hapus') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
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
            // JS UPDATING X
            $(document).on('click', '#btn-ubah', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/prodi/ajaxprodi/dataDosen/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#ubah-email').val(res.email);
                        $('#ubah-nidn').val(res.nidn);
                        $('#ubah-nama').val(res.nama);
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