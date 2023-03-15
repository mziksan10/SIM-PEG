@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-col">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="form-col">
    <a href="/bidang" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
    <button type="button" class="btn btn btn-warning shadow ml-1" data-toggle="modal" data-target="#importModal"><i class="fas fa-upload fa-sm"></i></button>
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header">
        <center>
            DAFTAR BIDANG<br>POLITEKNIK PIKSI GANESHA TAHUN {{date('Y')}}
        </center>
        </div>
        <div class="card-body">
        <div class="col">
            <div class="table-responsive">
            <table id="myTable" class="table table-border table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">Kode Bidang</th>
                                <th style="text-align: center">Nama Bidang</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_bidang as $item)
                            <tr>
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td style="text-align: center">{{ $item->kode_bidang }}</td>
                                <td style="text-align: center">{{ $item->nama_bidang }}</td>
                                <td style="text-align: center">
                                <button class="btn btn-sm" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm text-primary"></i> Show</button>
                                |
                                <button class="btn btn-sm"data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm text-warning"></i> Edit</button>
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
</div>

@include('bidang/modal/create')
@include('bidang/modal/show')
@include('bidang/modal/edit')
@include('bidang/modal/import')
@endsection