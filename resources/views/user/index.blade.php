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
<a href="/user" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
<button type="button" class="btn btn btn-primary shadow ml-1" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm"></i> Add</button>
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
    <div class="card shadow mb-4">
        <div class="card-body">
        <div class="col">
            <div class="table-responsive">
                <table id="myTable" class="table table-border table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">Username</th>
                                <th style="text-align: center">Role</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_user as $item)
                            <tr style="text-align: center">
                                <td>{{ $data_user->firstItem() + $loop->index }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->role }}</td>
                                <td>
                                @if( $item->role == 'admin' || $item->role == 'user' )
                                <div class="badge badge-success">Aktif</div>
                                @elseif( $item->role == 'guest' )
                                <div class="badge badge-danger">Non Aktif</div>
                                @endif
                                </td>
                                <td>
                                @if( $item->role == 'guest' || $item->role == 'user' )
                                <button class="btn btn-sm" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm text-primary"></i> Show</button>
                                |
                                <button class="btn btn-sm"data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm text-warning"></i> Edit</button>
                                @elseif( $item->role == 'admin' )
                                <button class="btn btn-sm" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm text-primary"></i> Show</button>
                                @endif
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

@include('user/modal/create')
@include('user/modal/edit')
@include('user/modal/show')

@endsection