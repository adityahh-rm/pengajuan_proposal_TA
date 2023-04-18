@extends('adminlte::page')

@section('title', 'Kelola Topik')

@section('content_header')
    @if($user->roles_id == 4)
        <h1>Topik</h1>
    @else
        <h1>Kelola Topik</h1>
    @endif
    
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @if ($user->roles_id == 2) 
                    <div class="card-body">
                        <button class="btn btn-success float-left" data-toggle="modal" data-target="#tambahTopikModal">
                            <i class="fa fa-plus"></i>
                            Tambah
                        </button>
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Pembimbing</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($topik as $top)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $top->judul_topik }}</td>
                                        <td>
                                            @if($top->status == 0)
                                                <span>Belum Diambil</span>
                                            @elseif($top->status == 1)
                                                <span>Sudah Diambil</span>
                                            @endif
                                        </td>
                                        <td>{{ $top->dosens->nama }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="btn-ubah" class="btn btn-success" 
                                                    data-toggle="modal" data-target="#ubahTopikModal" data-id="{{ $top->id }}">
                                                    Ubah
                                                </button>
                                                <button type="button" id="btn-hapus" class="btn btn-danger" data-toggle="modal" 
                                                    data-target="#hapusTopikModal" data-id="{{ $top->id }}" data-name="{{ $top->nama }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif ($user->roles_id == 4) 
                    <div class="card-body">
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($topik as $top)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $top->judul_topik }}</td>
                                            @if($top->status == 0)
                                                <td><span>Belum Diambil</span></td>
                                                <!-- Button - Modifikasi Data -->
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" id="btn-pilih" class="btn btn-success" 
                                                            data-toggle="modal" data-target="#pilihTopikModal" data-id="{{ $top->id }}">
                                                            Pilih
                                                        </button>
                                                    </div>
                                                </td>
                                            @else
                                                <td><span>Sudah Diambil</span></td>
                                                <td><span>Tidak Ada Aksi</span></td>
                                            @endif
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- M O D A L -->
<!-- Tambah Topik -->
<div  class="modal fade" id="tambahTopikModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTopikModal">
                    Tambah Topik
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('koordinator.kelolaTopik.tambah') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="judul_topik">Judul</label>
                            <input type="text" class="form-control" name="judul_topik" id="judul_topik" required />
                        </div>  
                        <div class="form-group">
                            <label for="ubah-dosen">Dosen</label>
                            <select name="dosen_id" id="dosen" class="form-control">
                                <option selected disabled> -- Select One --</option>
                                    @foreach ($dosen as $ds)
                                        @if($ds->status == 1)
                                            <option value="{{ $ds->id }}">
                                                {{ $ds->nama }}
                                            </option>
                                        @endif
                                    @endforeach 
                            </select>
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
<div class="modal fade" id="ubahTopikModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahTopikModal">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('koordinator.kelolaTopik.ubah') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ubah-judul">Judul</label>
                                    <input type="text" class="form-control" name="judul_topik" id="ubah-judul" required/>
                                </div>
                                <div class="form-group">
                                    <label for="ubah-dosen">Dosen</label>
                                    <select name="dosen_id" id="dosen" class="form-control">
                                        <option selected disabled> -- Select One --</option>
                                            @foreach ($dosen as $ds)
                                                @if($ds->status == 1)
                                                    <option value="{{ $ds->id }}">
                                                        {{ $ds->nama }}
                                                    </option>
                                                @endif
                                            @endforeach 
                                    </select>
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
<div class="modal fade" id="hapusTopikModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusTopikModal">
                    Hapus Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda Yakin Ingin Mengapus Data <strong><span id="caption"></span></strong>?
                <form method="post" action="{{ route('koordinator.kelolaTopik.hapus') }}" enctype="multipart/form-data">
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

<!-- Pilih Topik ||| Ngerubah Status Topik nya jadi 1 --> 
<div class="modal fade" id="pilihTopikModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihTopikModal">Konfirmasi Pilih Topik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('mahasiswa.kelolaTopik.pilih') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')    
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p>Apakah anda yakin akan memilih Topik ini ?</p>
                                </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="pilih-id"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success"> Ya </button>
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
                    url: baseurl+'/koordinator/ajaxkoordinator/dataTopik/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#ubah-judul').val(res.judul_topik);
                        $('#ubah-dosen').val(res.dosen_id);
                        $('#ubah-id').val(res.id);
                    },
                });
            }); 
        });

        $(function(){
            $(document).on('click', '#btn-pilih', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/mahasiswa/ajaxmahasiswa/dataTopik/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#pilih-id').val(res.id);
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