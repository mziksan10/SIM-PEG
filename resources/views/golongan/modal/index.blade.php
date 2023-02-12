@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-col">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="form-col">
    <a href="/golongan" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
    <a href="/export/golongan/" class="btn btn-success ml-1" target="_blank"><i class="fas fa-file-excel fa-sm"></i></a>
    <a href="/report/golongan/" class="btn btn-danger ml-1" target="_blank"><i class="fas fa-file-pdf fa-sm"></i></a>
    <button type="button" class="btn btn btn-warning shadow ml-1" data-toggle="modal" data-target="#importModal"><i class="fas fa-upload fa-sm"></i></button>
    <a href="/golongan/create/" class="btn btn btn-primary ml-1"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
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
        <div class="card-body">
        <div class="table-responsive">
            <table id="myTable">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th>No</th>
                            <th>Golongan</th>
                            <th>Pendidikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_golongan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->golongan }}</td>
                            <td>{{ $item->pendidikan }}</td>
                            @if($item->status == "Tetap")
                            <td><div class="badge badge-warning">{{ $item->status }}</div></td>
                            @elseif($item->status == "Kontrak")
                            <td><div class="badge badge-primary">{{ $item->status }}</div></td>
                            @endif
                            <td>
                                <button class="btn-circle btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm"></i></button>
                                <button class="btn-circle btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm"></i></button>
                                <form action="/golongan/{{ $item->id }}" method="post" class="d-inline">
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
        </div>
    </div>
    </div>
</div>

@include('golongan/modal/create')
@include('golongan/modal/edit')
@include('golongan/modal/show')
@endsection