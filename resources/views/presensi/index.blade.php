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
                    <a href="/presensi" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                    <form action="/export/presensi" method="GET">
                    @csrf
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text ml-1">From</span>
                    </div>
                    <input type="date" class="form-control col-4" name="fromDate">
                    <div class="input-group-prepend">
                        <span class="input-group-text">To</span>
                    </div>
                    <input type="date" class="form-control col-4" name="toDate">
                    <button type="submit" class="btn btn-success ml-1"><i class="fas fa-file-excel fa-sm"></i></button>
                    </div>
                    </form>                    
                </div>
                <div class="col-4">
                    <form action="/export/presensi" method="GET">
                        <div class="input-group"> 
                            <input type="date" class="form-control small" name="search" value="{{ request('search') }}">
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
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Sesi</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_presensi as $item)
                        <tr>
                            <td>{{ $data_presensi->firstItem() + $loop->index }}</td>
                            <td>{{ $item->pegawai->nip }}</td>
                            <td>{{ $item->pegawai->nama }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_keluar }}</td>
                            <td></td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end">
                    {{ $data_presensi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection