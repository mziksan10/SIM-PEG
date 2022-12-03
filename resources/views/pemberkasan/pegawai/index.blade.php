@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header">
                <form action="/berkas" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pegawai_id" value="{{ session()->get('pegawai_id') }}">
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">Jenis Berkas</span>
                                </div>
                                <select name="jenis_berkas" class="form-control @error('jenis_berkas') is-invalid @enderror" autofocus>
                                    <option value="" selected>--Pilih--</option>
                                    @foreach($jenis_berkas as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_berkas')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan" name="keterangan">
                            </div>
                            @error('keterangan')
                            <div class="invalid-feedback ml-3">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                                <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-upload fa-sm"></i> Upload</button>
                                </div>
                                @error('file')
                                <div class="invalid-feedback ml-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="d-none d-md-block mt-0">
                <div class="row d-flex justify-content-end">
                    <div class="col-8 d-flex justify-content-start">
                        <a href="/pemberkasan-pegawai" class="btn btn-primary mr-2"><i class="fas fa-sync fa-sm"></i></a>
                        <h6 class="font-weight-bold text-primary mt-auto">Data Pemberkasan</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <form action="/pemberkasan-pegawai" method="GET">
                                <div class="input-group"> 
                                    <input type="text" class="form-control small" placeholder="Search for.." name="search" value="{{ request('search') }}">
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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr class="bg-primary my-font-white">
                                <th>No</th>
                                <th>Jenis Berkas</th>
                                <th>Keterangan</th>
                                <th style="text-align: center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_berkas as $item)
                            <tr>
                                <td>{{ $data_berkas->firstItem() + $loop->index }}</td>
                                <td>{{ $item->jenis_berkas }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td style="text-align: center">
                                    <a href="{{asset('storage/' . $item->file)}}" class="btn-circle btn-sm btn-primary" target="_blank"><i class="fas fa-eye fa-sm"></i></a>
                                    <form action="/berkas/{{ $item->id }}" method="post" class="d-inline">
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
                            {{ $data_berkas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection