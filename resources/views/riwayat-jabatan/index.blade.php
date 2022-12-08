@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm text-white-50"></i> Add</button>
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
                    <a href="/riwayat-jabatan" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                </div>
                <div class="col-4">
                    <form action="/riwayat-jabatan" method="GET">
                        <div class="input-group"> 
                            <input type="text" class="form-control small" placeholder="Search for NIP.." name="search" value="{{ request('search') }}">
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
                            <th>NIP</th>
                            <th>Bidang</th>
                            <th>Jabatan</th>
                            <th>Golongan</th>
                            <th>Tanggal SK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data_riwayatjabatan as $item)
                    @if($item->pegawai === null)
                    @elseif($item->pegawai)
                    <tr>
                        <td>{{ $data_riwayatjabatan->firstItem() + $loop->index }}</td>
                        <td>{{ $item->pegawai->nip }}</td>
                        <td>{{ $item->bidang->nama_bidang }}</td>
                        <td>{{ $item->jabatan->nama_jabatan }}</td>
                        <td>
                        {{ $item->golongan->golongan . " - " }}
                        @if( $item->golongan->status == 'Kontrak')
                        <div class="badge badge-warning">Kontrak</div>
                        @elseif( $item->golongan->status == 'Tetap')
                        <div class="badge badge-primary">Tetap</div>
                        @endif
                        </td>
                        <td>{{ date('d/m/Y', strtotime($item->tanggal_sk)) }}</td>
                        <td>
                            <button class="btn-circle btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm"></i></button>
                            <form action="/bidang/{{ $item->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn-circle btn-sm btn-danger border-0" onclick="return confirm('Apakah kamu yakin?')"><i class="fas fa-trash fa-sm"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end">
                        <!-- Tombol Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@include('riwayat-jabatan/modal/create')
@include('riwayat-jabatan/modal/show')
@endsection