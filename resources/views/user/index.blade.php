@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>
<div class="form-col">
<a href="/user" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
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
        <div class="card-body">
        <div class="table-responsive">
            <table id="myTable">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th style="text-align: center">No</th>
                            <th style="text-align: center">Username</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_user as $item)
                        <tr>
                            <td>{{ $data_user->firstItem() + $loop->index }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td style="text-align: center">
                            @if( $item->role == 'admin' || $item->role == 'user' )
                            <div class="badge badge-success">Aktif</div>
                            @elseif( $item->role == 'guest' )
                            <div class="badge badge-danger">Non Aktif</div>
                            @endif
                            </td>
                            <td style="text-align: center">
                                <button class="btn-circle btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm"></i></button>
                                <button class="btn-circle btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm"></i></button>
                                <form action="/user/{{ $item->id }}" method="post" class="d-inline">
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

@include('user/modal/create')
@include('user/modal/edit')
@include('user/modal/show')

@endsection