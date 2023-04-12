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
<!-- Belum ada -->
</ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Content Row -->
<div class="row">
    <div class="col">
    @if(session()->has('success'))                                
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <small>{{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif(session()->has('failed'))                                
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>{{ session('failed') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    <!-- DataTales Example -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
        <div class="row">
            @foreach($data_aturanPresensi as $item)
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">{{ 'Sesi ' . $item->sesi }}</div>
                                <div class="text-xl font-weight-bold text-gray-800 mb-1">{{ 'Jam Masuk: ' . $item->jam_masuk }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-business-time fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                                <center>
                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#showModalAturan{{ $item->id }}"><i class="fas fa-eye text-primary"></i> Show</small></button>
                                    |
                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#editModalAturan{{ $item->id }}"><i class="fas fa-edit text-warning"></i> Edit</small></button>
                                </center>
                        </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <small>
                <b>Perhatian</b>
                <ul>
                    <li>Validasi berdasarkan jaringan <i>IP Public</i> milik kampus saat ini.</li>
                    <li>Jika ada <i>trouble</i> segera hubungi <i>developer</i>.</li>
                </ul>
            </small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    </div>
    </div>
</div>
@include('presensi/modal/edit-aturan')
@include('presensi/modal/show-aturan')
@endsection