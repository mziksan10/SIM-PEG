@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>
<div class="form-col">
    <form action="{{ route('import-jabatan') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="input-group">
        <input type="file" name="file" class="form-control">
        <div class="input-group-append">
        <button class="btn btn-warning mr-1" type="submit"><i class="fas fa-upload fa-sm"></i> Impor</button>
        </div>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm text-white-50"></i> Add</button>
    </div>
    </form>
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
            <div class="row">
                <div class="col-8 d-flex justify-content-start">
                    <a href="/jabatan" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                    <a href="/export/jabatan/" class="btn btn-success ml-1"><i class="fas fa-file-excel fa-sm"></i></a>
                </div>
                <div class="col-4">
                    <form action="/jabatan" method="GET">
                        <div class="input-group"> 
                            <input type="text" class="form-control small" placeholder="Search for Kode / Nama Jabatan.." name="search" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" style="text-align: center">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Jabatan</th>
                            <th>Bidang</th>
                            <th>Dibuat Pada</th>
                            <th>Diubah Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_jabatan as $item)
                        <tr>
                            <td>{{ $data_jabatan->firstItem() + $loop->index }}</td>
                            <td>{{ $item->kode_jabatan }}</td>
                            <td>{{ $item->nama_jabatan }}</td>
                            <td>{{ $item->bidang->nama_bidang }}</td>
                            <td>{{ date("d-m-Y", strtotime($item->created_at)) }}</td>
                            <td>{{ date("d-m-Y", strtotime($item->updated_at)) }}</td>
                            <td>
                                <button class="btn-circle btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm"></i></button>
                                <form action="/jabatan/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn-circle btn-sm btn-danger border-0" onclick="return confirm('Apakah kamu yakin?')"><i class="fas fa-trash fa-sm"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end">
                        {{ $data_jabatan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@include('jabatan/modal/create')
@include('jabatan/modal/edit')
@endsection