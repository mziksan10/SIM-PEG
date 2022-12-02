@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="card shadow text-center mb-4">
        <div class="card-header">
            Waktu
        </div>
        <div class="card-body">
            <h3 id="jam" class="card-title"></h3>
            <p class="card-text">{{ date('l, d F Y') }}</b></p>
            @if($presensi == null)
            <form action="/presensi-pegawai" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit">Absen Masuk</button>
            </form>
            @elseif($presensi != null)
            <form action="/presensi-pegawai" method="POST">
            @method('put')
            @csrf
            <button class="btn btn-danger" type="submit">Absen Pulang</button>
            </form>
            @endif
        </div>
        @if(session()->has('success'))
        <div class="card-footer text-success">
            <small><i>{{ session('success') }}</i></small>
        </div>
        @elseif(session()->has('failed'))
        <div class="card-footer text-danger">
            <small><i>{{ session('failed') }}</i></small>
        </div>
        @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-8 d-flex justify-content-start">
                    <a href="/presensi-pegawai" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                </div>
                <div class="col-4">
                <form action="" method="get">
                        <div class="input-group">
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th style="text-align: center">Jam Masuk</th>
                            <th style="text-align: center">Jam Keluar</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_presensi as $item)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td style="text-align: center">{{ $item->jam_masuk }}</td>
                        <td style="text-align: center">{{ $item->jam_keluar }}</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center">{{ $item->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection