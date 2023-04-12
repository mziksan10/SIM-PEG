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
<a href="/pegawai" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
    <a href="/export/pegawai/" class="btn btn-success ml-1" target="_blank"><i class="fas fa-file-excel fa-sm"></i></a>
    <a href="/report/pegawai/" class="btn btn-danger ml-1" target="_blank"><i class="fas fa-file-pdf fa-sm"></i></a>
    <button type="button" class="btn btn btn-warning ml-1" data-toggle="modal" data-target="#importModal"><i class="fas fa-upload fa-sm"></i></button>
    <button type="button" class="btn btn btn-primary ml-1" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm"></i> Add</button>
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
        <div class="card-header">
        <center>
            DAFTAR PEGAWAI<br>POLITEKNIK PIKSI GANESHA TAHUN {{date('Y')}}
        </center>
        </div>
        <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tetap-tab" data-toggle="tab" data-target="#tetap" type="button" role="tab" aria-controls="tetap" aria-selected="true"><a href="#" class="badge badge-primary">{{ $data_pegawaiTetap }}</a> | Pegawai Tetap</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kontrak-tab" data-toggle="tab" data-target="#kontrak" type="button" role="tab" aria-controls="kontrak" aria-selected="false"><a href="#" class="badge badge-warning">{{ $data_pegawaiKontrak }}</a> | Pegawai Kontrak</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="magang-tab" data-toggle="tab" data-target="#magang" type="button" role="tab" aria-controls="magang" aria-selected="false"><a href="#" class="badge badge-success">{{ $data_pegawaiMagang }}</a> | Pegawai Magang</button>
        </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        <?php foreach ($status as $tab) : if ($tab != 0) { ?>
        <div class="tab-pane fade show <?php if ($tab == 1) { echo 'active';} ?>" id="<?php if ($tab == 1) { echo 'tetap';} elseif ($tab == 2) { echo 'kontrak';} elseif ($tab == 3) { echo 'magang';} ?>" role="tabpanel" aria-labelledby="<?php if ($tab == 1) { echo 'tetap-tab';} elseif ($tab == 2) { echo 'kontrak-tab';} elseif ($tab == 3) { echo 'magang-tab';} ?>">
        <div class="card-body">
        <div class="table-responsive">
            <table id="<?php if ($tab == 1) { echo 'tetapTable';} elseif ($tab == 2) { echo 'kontrakTable';} else { echo 'magangTable';} ?>" class="table table-border table-hover">
                <thead>
                    <tr class="bg-light">
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Foto</th>
                        <th style="text-align: center">NIP</th>
                        <th style="text-align: center">Nama</th>
                        <th style="text-align: center">Bidang</th>
                        <th style="text-align: center">Jabatan</th>
                        <th style="text-align: center">Lama Bekerja</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($data_pegawai as $item)
                    @if($item->status == $tab)
                    @if($item->nip)
                    <?php
                            $tanggal_masuk = new DateTime("$item->tanggal_masuk");
                            $sekarang = new DateTime("today");
                            if ($tanggal_masuk > $sekarang) { 
                            $thn = "0";
                            $bln = "0";
                            $tgl = "0";
                            }
                            $thn = $sekarang->diff($tanggal_masuk)->y;
                            $bln = $sekarang->diff($tanggal_masuk)->m;
                            $tgl = $sekarang->diff($tanggal_masuk)->d;
                    ?>
                    <tr class="@if( $item->riwayatJabatan == null) @else @if( $thn > $item->riwayatJabatan->golongan->min_masa_kerja && $thn != $item->riwayatJabatan->golongan->min_masa_kerja ) flash @endif @endif">
                        <td style="text-align: center">{{  $no++ }}</td>
                        <td>
                            <center>
                            @if($item->foto)
                            <div style="max-height: 60px; max-width: 50px; overflow: hidden;">
                            <img src="{{asset('storage/' . $item->foto)}}" class="img-thumbnail" style="height:60px; width:50px;">
                            </div>
                            @else
                            <div style="max-height: 60px; max-width: 50px; overflow: hidden;">
                            <img src="{{asset('/assets/img/user_default.png')}}" class="img-thumbnail" style="height:60px; width:50px;">
                            </div>
                            @endif
                            </center>
                        </td>
                        <td style="text-align: center">{{ $item->nip }}</td>
                        <td>{{ $item->nama }}</td>
                        @if($item->riwayatJabatan === null)
                        <td style="text-align: center"><div class="badge badge-warning text-wrap">Belum Terdaftar</div></td>
                        <td style="text-align: center"><div class="badge badge-warning text-wrap">Belum Terdaftar</div></td>
                        <td style="text-align: center"><div class="badge badge-warning text-wrap">Belum Terdaftar</div></td>
                        @elseif($item->riwayatJabatan)
                        <td style="text-align: center">{{ ucwords(strtolower($item->riwayatJabatan->bidang->nama_bidang)) }}</td>
                        <td style="text-align: center">{{ ucwords(strtolower($item->riwayatJabatan->jabatan->nama_jabatan)) }}</td>
                        @endif
                        <td style="text-align: center" class="align-middle"><a href="#" class="badge badge-primary align-middle">{{ $thn." Tahun" }} <br> {{ $bln." Bulan ".$tgl." Hari" }}</a></td>
                        <td style="text-align: center" class="align-middle">
                            <a href="{{ route('showPegawai', $item->id) }}" class="btn btn-sm @if( $item->riwayatJabatan == null) text-primary @else @if( $thn > $item->riwayatJabatan->golongan->min_masa_kerja && $thn != $item->riwayatJabatan->golongan->min_masa_kerja ) text-white @endif @endif"><i class="fas fa-eye fa-sm @if( $item->riwayatJabatan == null) @else @if( $thn > $item->riwayatJabatan->golongan->min_masa_kerja && $thn != $item->riwayatJabatan->golongan->min_masa_kerja ) text-white @endif @endif"></i> Show</a>
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        </div>
        <?php }endforeach; ?>
        </div>
        </div>
    </div>

    </div>
</div>
<div class="row">
<div class="col">
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
        <small>
            <b>Perhatian</b>
            <ul>
                <li>Untuk menambahkan data pegawai lama gunakan fitur import pegawai.</li>
                <li>NIP sudah di generate secara otomatis oleh sistem.</li>
                <li>Ukuran foto tidak boleh lebih dari 1 MB.</li>
                <li>Penulisan nama & gelar harus benar.</li>
            </ul>
        </small>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
</div>
@include('pegawai/modal/create')
@include('pegawai/modal/import')
@endsection