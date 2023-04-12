@extends('layouts/main')
@section('container')
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<div class="col">
    Home / <a href="#">{{ $title }}</a>
</div>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">
<!-- belum ada -->
</ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="card shadow-sm text-center mb-4">
        <div class="card-header">
            <small class="text-muted"><i>Hallo {{ ucwords(session()->get('nama')) }}!</i></small>
        </div>
        <div class="card-body">
            @if(session()->get('foto') == null)
            <img class="img-profile rounded-circle" src="{{asset('/assets/img/user_default.png')}}" width="100">
            @elseif(session()->get('foto'))
            <img class="img-thumbnail rounded-circle mb-3 mt-3" style="width:100px; height:100px" src="{{asset('storage/' . session()->get('foto'))}}">
            @endif
            <h1 id="jam" class="card-title"></h1>
            <p class="card-text">{{ date('l, d F Y') }}</p>
            @if($presensi == null)
            <form action="{{ route('absenMasuk') }}" method="POST">
            @csrf
            <button class="btn btn-primary mb-4" type="submit">Absen Masuk</button>
            </form>
            @elseif($presensi->keterangan == null)
            <form action="{{ route('absenPulang') }}" method="POST">
            @method('put')
            @csrf
            <button class="btn btn-danger mb-4" type="submit">Absen Pulang</button>
            </form>
            @elseif($presensi->keterangan != null)
            <!-- Kosong -->
            @endif
            <div class="table-responsive container">
            <table class="table" width="100%" cellspacing="0" style="text-align: center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Sesi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach($data_presensi as $item)
                    <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jam_masuk }}</td>
                    <td>{{ $item->jam_keluar }}</td>
                    <td>{{ $item->sesi }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->keterangan }}</td>
                    </tr>
                    @endforeach
            </table>
            </div>
        </div>
        <div class="card-footer">
        @if(session()->has('success'))
            <small class="text-success"><i>{{ session('success') }}</i></small>
        @elseif(session()->has('failed'))
            <small class="text-danger"><i>{{ session('failed') }}</i></small>
        @else
            <small class="text-muted"><i>Semoga harimu menyenangkan :)</i></small>
        @endif
        </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-2">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-history"></i> Riwayat Kehadiran Bulan Ini</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                        <h6 class="small mt-auto">Total Hadir: <b>{{ $jumlah_kehadiranBulanIni }}</b> Hari.</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table id="myTable" class="table table-border table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Sesi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data_kehadiranBulanIni as $item)
                    <tr>
                        <td></td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jam_masuk }}</td>
                        <td>{{ $item->jam_keluar }}</td>
                        <td>{{ $item->sesi }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
        </div>

@endsection