@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-col">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="form-col">
        <form action="{{ route('import-pegawai') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <input type="file" name="file" class="form-control">
            <div class="input-group-append">
            <button class="btn btn-warning mr-1" type="submit"><i class="fas fa-upload fa-sm"></i> Import</button>
            </div>
            <a href="/pegawai/create/" class="btn btn btn-primary shadow"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
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
                    <a href="/pegawai" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                    <a href="/export/pegawai/" class="btn btn-success ml-1" target="_blank"><i class="fas fa-file-excel fa-sm"></i> Excel</a>
                    <a href="/report/pegawai/" class="btn btn-danger ml-1" target="_blank"><i class="fas fa-file-pdf fa-sm"></i> PDF</a>
                </div>
                <div class="col-4">
                <form action="/pegawai" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control small" placeholder="Search for NIP / Nama.." name="search" value="{{ request('search') }}">
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
                            <th style="text-align: center">Foto</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Bidang</th>
                            <th>Jabatan</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_pegawai as $item)
                        <tr>
                            <td>{{ $data_pegawai->firstItem() + $loop->index }}</td>
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
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            @if($item->riwayatJabatan === null)
                            <td><div class="badge badge-warning">Belum Terdaftar</div></td>
                            <td><div class="badge badge-warning">Belum Terdaftar</div></td>
                            @elseif($item->riwayatJabatan)
                            <td>{{ $item->riwayatJabatan->bidang->nama_bidang }}</td>
                            <td>{{ $item->riwayatJabatan->jabatan->nama_jabatan }}</td>
                            @endif
                            @if($item->status == 'Aktif')
                            <td style="text-align: center"><div class="badge badge-success">Aktif</div></td>
                            @elseif($item->status == 'Non Aktif')
                            <td style="text-align: center"><div class="badge badge-danger">Non Aktif</div></td>
                            @endif
                            <td style="text-align: center">
                                <a href="/pegawai/{{ $item->id }}" class="btn-circle btn-sm btn-primary"><i class="fas fa-eye fa-sm"></i></a>
                                <a href="/pegawai/{{ $item->id }}/edit" class="btn-circle btn-sm btn-warning"><i class="fas fa-edit fa-sm"></i></a>
                                <form action="/pegawai/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn-circle btn-sm btn-danger border-0"><i class="fas fa-trash fa-sm"></i></button>
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
                        {{ $data_pegawai->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
@endsection