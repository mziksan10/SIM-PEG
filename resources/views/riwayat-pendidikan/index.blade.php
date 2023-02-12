@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>
<div class="form-col">
<a href="/riwayat-pendidikan" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
<button type="button" class="btn btn btn-primary shadow ml-1" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm"></i> Add</button>
</div>
</div>

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
        <div class="card shadow mb-4">
        <div class="card-header">
        <center>
            RIWAYAT PENDIDIKAN PEGAWAI<br>POLITEKNIK PIKSI GANESHA TAHUN {{date('Y')}}
        </center>
        </div>
            <div class="card-body">
            <div class="table-responsive">
            <table id="myTable">
                        <thead>
                            <tr class="bg-primary my-font-white">
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">NIP</th>
                                <th style="text-align: center">Jenjang</th>
                                <th style="text-align: center">Jurusan</th>
                                <th style="text-align: center">Tahun Lulus</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($data_riwayatPendidikan as $item)
                            <tr>
                            <td style="text-align: center">{{$no++}}</td>
                            <td style="text-align: center">{{$item->pegawai->nip}}</td>
                            <td style="text-align: center">{{$item->jenjang}}</td>
                            <td style="text-align: center">{{$item->jurusan}}</td>
                            <td style="text-align: center">{{$item->tahun_lulus}}</td>
                            <td style="text-align: center">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm"></i> Detail</button>
                            <button class="btn btn-sm btn-warning"data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm"></i> Edit</a>
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
@include('riwayat-pendidikan/modal/create')
@include('riwayat-pendidikan/modal/show')
@include('riwayat-pendidikan/modal/edit')
@endsection