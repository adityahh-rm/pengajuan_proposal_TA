@extends('adminlte::page')

@section('title', 'Laporan Pengajuan')

@section('content_header')
    <h1>Laporan Pengajuan</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="my-2">
                        <form action= "{{ route('Laporan.filter') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="start_date">
                                <input type="date" class="form-control" name="end_date">
                                <button class="btn btn-secondary" type="submit"> <i class="fa fa-filter"></i> Filter </button>
                            </div>
                        </form>
                    </div>
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Judul</th>
                                    <th>Pembimbing</th>
                                    <th>Tanggal Disetujui</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($proposal as $prop)
                                    @if($prop->status == 3)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $prop->users->name }}</td>
                                            <td>{{ $prop->judul }}</td>
                                            <td>{{ $prop->dosens->nama }}</td>
                                            <td>{{ $prop->updated_at->format('d F Y') }}</td>
                                            <td><i class="fa fa-check"></i>Bimbingan</td>
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
@stop