@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row justify-content-header">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Selamat Datang <strong>{{$user->name}}</strong></div>
                <div class="card-body">
                        <div class="row justify-content-center">
                        @if($user->roles_id == 1)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Dosen Aktif</span>
                                        <span class="info-box-number">{{ $jumlahDosen }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Mahasiswa Aktif</span>
                                        <span class="info-box-number">{{ $jumlahMahasiswa }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-address-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total User</span>
                                        <span class="info-box-number">{{ $jumlahUser }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-gray"><i class="fa fa-address-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Proposal Disetujui</span>
                                        <span class="info-box-number">{{ $totalProposalDisetujui }}</span>
                                    </div>
                                </div>
                            </div>
                        
                        @elseif($user->roles_id == 2)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-white"><i class="fa fa-map"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Rekomendasi Topik</span>
                                        <span class="info-box-number">{{ $totalTopik }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-battery-empty"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Proposal</span>
                                        <span class="info-box-number">{{ $totalProposal }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-battery-half"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Proposal Revisi</span>
                                        <span class="info-box-number">{{ $totalProposalRevisi }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-battery-full"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Proposal Disetujui</span>
                                        <span class="info-box-number">{{ $totalProposalDiterima }}</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->roles_id == 3)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-flag"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Menunggu Persetujuan</span>
                                        <span class="info-box-number">{{ $statusProposalMenungguDosen }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-flag-checkered"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Disetujui</span>
                                        <span class="info-box-number">{{ $statusProposalDisetujuiDosen }}</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->roles_id == 4)
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop