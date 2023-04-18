@extends('adminlte::page')

@section('title', 'Pengajuan Proposal')

@section('content_header')
    <h1>Pengajuan Proposal</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <!--Mahasiswa-->
                    @if ($user->roles_id == 4) 
                        <div class="card-body">
                            <button class="btn btn-success float-left" data-toggle="modal" data-target="#tambahPengajuanModal">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </button>
                            <!-- @foreach($proposalByUser as $prop)
                                @if($prop->status == 0 or $prop->status == 1)
                                    <button class="btn btn-success float-left" data-toggle="modal" data-target="#tambahPengajuanModal" disabled>
                                        <i class="fa fa-plus"></i>
                                        Tambah
                                    </button>
                                @endif
                            @endforeach -->
                            <table id="table-data" class="table table-borderer">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Proposal</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proposalByUser as $prop)
                                    <tr>
                                        <td>{{ $prop->judul }}</td>
                                        <td>
                                            <a href="download_proposal/{{$prop->berkas}}" target="_blank"><i class="fa fa-file-pdf" aria-hidden="true"></i>{{$prop->berkas}}</a>
                                            <!-- <a data-toggle="modal"  data-target="#tampilProposal" data-id="{{ $prop->id }}" href="#tampilProposal">
                                                <i class="fa fa-file-pdf" aria-hidden="true"></i>{{ $prop->berkas }}
                                            </a> -->
                                        </td>
                                        <td>{{ $prop->updated_at->format('d F Y') }}</td>
                                        <!-- Button - Revisi when Status = 2 
                                            0. Menunggu - Tidak Ada Aksi
                                            1. Revisi, - button Revisi
                                            2 = Menunggu Dosen - tidak ada aksi
                                            3 = Disetujui - tidak ada aksi
                                        -->
                                        @if($prop->status == 0)
                                            <td>Menunggu</td>
                                            <td>Tidak ada Aksi</td>
                                        @elseif($prop->status == 1)
                                            <td>Revisi</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-lihat" class="btn btn-secondary" 
                                                        data-toggle="modal" data-target="#lihatRevisi" data-id="{{ $prop->id }}">
                                                        Lihat Revisi
                                                    </button>
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-revisiProposal" class="btn btn-danger" 
                                                        data-toggle="modal" data-target="#revisiProposal" data-id="{{ $prop->id }}">
                                                        Revisi
                                                    </button>
                                                </div>
                                            </td>
                                        @elseif($prop->status == 2)
                                            <td>Menunggu Dosen</td>
                                            <td>Tidak Ada Aksi</td>
                                        @elseif($prop->status == 3)
                                            <td>Disetujui</td>
                                            <td>{{$prop->dosens->nama}}</td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <!--Koordinator-->       
                    @elseif ($user->roles_id == 2)
                        <div class="card-body">
                            <table id="table-data" class="table table-borderer">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Proposal</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach($proposal as $prop)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $prop->judul }}</td>
                                        <td>
                                            <a href="download_proposal/{{$prop->berkas}}" target="_blank"><i class="fa fa-file-pdf" aria-hidden="true"></i>{{$prop->berkas}}</a>
                                            <!-- <a data-toggle="modal"  data-target="#tampilProposal" data-id="{{ $prop->id }}" href="#tampilProposal">
                                                <i class="fa fa-file-pdf" aria-hidden="true"></i>{{ $prop->berkas }}
                                            </a> -->
                                        </td>
                                        <td>{{ $prop->updated_at->format('d F Y') }}</td>
                                        <!-- Button - Revisi when Status = 2 
                                            0. Menunggu - Tidak Ada Aksi
                                            1. Revisi, - button Revisi
                                            2 = Menunggu Dosen - Button Pilih Dosen
                                            3 = Disetujui - tidak ada aksi
                                        -->
                                        <td>
                                            @if($prop->status == 0)
                                                <span>Menunggu Pengecekan</span>
                                            @elseif($prop->status == 1)
                                                <span>Dalam Perbaikan</span>
                                            @elseif($prop->status == 2)
                                                <span>Pilih Dosen Pembimbing</span>
                                            @elseif($prop->status == 3)
                                                <span>Disetujui</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($prop->status == 0 or $prop->status == 1)
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-revisi" class="btn btn-danger" 
                                                        data-toggle="modal" data-target="#revisiPengajuanKoordinator" data-id="{{ $prop->id }}">
                                                        Revisi
                                                    </button>
                                                    <!-- Muncul Modal Untuk Mengirimkan Feedback -->
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-validasi" class="btn btn-success" 
                                                        data-toggle="modal" data-target="#validasiProposal" data-id="{{ $prop->id }}">
                                                        Terima
                                                    </button>
                                                </div>
                                            @elseif ($prop->status == 2)     
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-pengajuanPembimbing" class="btn btn-secondary" 
                                                        data-toggle="modal" data-target="#pilihPembimbingModal" data-id="{{ $prop->id }}">
                                                        Pilih Pembimbing
                                                    </button>
                                                </div>
                                            @elseif ($prop->status == 3)
                                                <span>Tidak ada Aksi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <!--Dosen-->   
                    @elseif ($user->roles_id == 3)
                        <div class="card-body">
                            <table id="table-data" class="table table-borderer">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Proposal</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach($proposalByDosen as $prop)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $prop->judul }}</td>
                                        <td>
                                            <a href="download_proposal/{{$prop->berkas}}" target="_blank"><i class="fa fa-file-pdf" aria-hidden="true"></i>{{$prop->berkas}}</a>
                                        </td>
                                        <td>{{ $prop->updated_at->format('d F Y') }}</td>
                                        <td>
                                            @if($prop->status == 3)
                                                <span>Lakukan Bimbingan</span>
                                            @elseif($prop->status == 2)
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-konfirmasiDosen" class="btn btn-success" 
                                                        data-toggle="modal" data-target="#validasiProposal" data-id="{{ $prop->id }}">
                                                        Terima
                                                    </button>
                                                </div>
                                            @else
                                                <span>Tidak Ada Aksi</span>
                                            @endif
                                        </td>
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

<!-- Tampil Proposal -->
<!-- <div id="tampilProposal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tampilProposal">Lihat Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($proposal as $prop)
                    <embed src=".../storage/fileproposal/{{$prop->berkas}}" frameborder="0" width="100%" height="600px"></embed>
                @endforeach
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> -->


<!-- Mahasiswa -->
<!-- Tambah Pengajuan -->
<div  class="modal fade" id="tambahPengajuanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPengajuanModal">Pengajuan Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('mahasiswa.pengajuan.tambah') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" id="judul" required autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label for="berkas_kp">Report KP</label>
                            <input type="file" class="form-control" name="berkas_kp" id="berkas_kp" required autocomplete="off"/>
                        </div> 
                        <div class="form-group">
                            <label for="berkas">Proposal</label>
                            <input type="file" class="form-control" name="proposal" id="berkas" required autocomplete="off"/>
                            <label for="" style="color: red">File harus berupa pdf</label>
                        </div>       
            </div>
            <div class="modal-footer">
                <input type="hidden" name="users_id" value="{{$user->id}}">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit"  value="submit" class="btn btn-primary">Ajukan</button>
                </form>
            </div>     
        </div>
    </div>
</div>
<!-- Revisi Proposal -->
<div class="modal fade" id="revisiProposal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="revisiProposal">Revisi Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('mahasiswa.pengajuan.revisi') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ubah-judul">Judul</label>
                                    <input type="text" class="form-control" name="ubah-judul" id="ubah-judul" required disabled/>
                                </div>
                                <div class="form-group">
                                    <label for="berkas">Proposal Revisi</label>
                                    <input type="file" class="form-control" name="berkas" id="berkas" required autocomplete="off"/>
                                    <label for="" style="color: red">File harus berupa pdf</label>
                                </div>   
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="users_id" value="{{$user->id}}">    
                <input type="hidden" name="id" id="proposal--proposal"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Lihat Revisi -->
<div class="modal fade" id="lihatRevisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatRevisi">Detail Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lihat-revisi">Feedback</label> 
                            <textarea class="form-control" name="lihat-revisi" id="lihat-revisi" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="id-lihat-revisi"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<!-- Koordinator -->
<!--  Revisi Pengajuan -->
<div  class="modal fade" id="revisiPengajuanKoordinator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="revisiPengajuanKoordinator">Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('koordinator.pengajuan.revisi') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <div class="form-group">
                            <label for="feedback">Feedback</label>
                            <textarea class="form-control" name="feedback" id="feedback"></textarea>
                        </div>      
            </div>
            <div class="modal-footer">
                <input type="hidden" name="users_id" value="{{$user->id}}">
                <input type="hidden" name="id-proposal-feedback" id="id-proposal-feedback" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>     
        </div>
    </div>
</div>
<!-- Pilih Dosen Pembimbing -->
<div class="modal fade" id="pilihPembimbingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihPembimbingModal">Pilih Pembimbing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('koordinator.pengajuan.pembimbing') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dosen_id">Dosen Pembimbing</label>
                                    <select name="dosen_id" id="dosen_id" class="form-control">
                                        <option selected disabled> -- Pilih Dosen Pembimbing --</option>
                                        @foreach ($dosens as $dosen)
                                            @if ($dosen->status == 1)
                                                <option value="{{ $dosen->id }}">  {{ $dosen->nama }}  </option>
                                            @endif
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="users_id" value="{{$user->id}}">
                <input type="hidden" name="id" id="id-proposal-dosen"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- validasiPengajuan -->
<div class="modal fade" id="validasiProposal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validasiProposal">Konfirmasi Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($user-> roles_id == 2)
                    <form method="post" action="{{ route('koordinator.pengajuan.terima') }}" enctype="multipart/form-data">
                @elseif ($user->roles_id==3)
                    <form method="post" action="{{ route('dosen.pengajuan.validasi') }}" enctype="multipart/form-data">
                @endif

                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p>Apakah anda yakin akan menerima Proposal ini.</p>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="users_id" value="{{$user->id}}"> 
                <input type="hidden" name="id" id="validasi-id">   
                <input type="hidden" name="id-validasi-dosen" id="id-validasi-dosen">   
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" value="submit" class="btn btn-success">Terima</button>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('js')
    <script>
        $(function(){
            $(document).on('click', '#btn-lihat', function(){
                let id = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: baseurl+'/mahasiswa/Pengajuan/lihat/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#lihat-revisi').val(res.feedback);
                        $('#id-lihat-revisi').val(res.id);
                    },
                });
            }); 
        });
        
        $(function(){
            $(document).on('click', '#btn-revisi', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/koordinator/ajaxkoordinator/dataPengajuan/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#id-proposal-feedback').val(res.id);

                    },
                });
            }); 
        });

        $(function(){
            $(document).on('click', '#btn-revisiProposal', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/mahasiswa/Pengajuan/lihat/'+id,
                    dataType: 'json',
                    success: function(res){
                        console.log(res);
                        $('#ubah-judul').val(res.judul);
                        $('#edit-old-berkas').val(res.old-berkas);
                        $('#proposal--proposal').val(res.id);
                    },
                });
            }); 
        });

        $(function(){
            $(document).on('click', '#btn-validasi', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/koordinator/ajaxkoordinator/dataPengajuan/'+id,
                    dataType: 'json',
                    success: function(res){
                        console.log(res);
                        $('#validasi-id').val(res.id);
                    },
                });
            }); 
        });

        $(function(){
            $(document).on('click', '#btn-pengajuanPembimbing', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/koordinator/ajaxkoordinator/dataPengajuan/'+id,
                    dataType: 'json',
                    success: function(res){
                        console.log(res);
                        $('#id-proposal-dosen').val(res.id);
                    },
                });
            }); 
        });

        $(function(){
            $(document).on('click', '#btn-konfirmasiDosen', function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: baseurl+'/dosen/ajaxdosen/dataPengajuan/'+id,
                    dataType: 'json',
                    success: function(res){
                        console.log(res);
                        $('#id-validasi-dosen').val(res.id);
                    },
                });
            }); 
        });


    </script>
</script>
@stop