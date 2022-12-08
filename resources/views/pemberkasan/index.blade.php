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
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row d-flex justify-content-end">
                    <div class="col-8 d-flex justify-content-start">
                        <a href="/pemberkasan" class="btn btn-primary mr-2"><i class="fas fa-sync fa-sm"></i></a>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <form action="/pemberkasan" method="GET">
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
                    <table class="table table-bordered" width="100%" cellspacing="0" style="text-align: center">
                        <thead>
                            <tr class="bg-primary my-font-white">
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis Berkas</th>
                                <th>Keterangan</th>
                                <th>Tanggal DiBuat</th>
                                <th>Tanggal DiUbah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_berkas as $item)
                            <tr>
                                <td>{{ $data_berkas->firstItem() + $loop->index }}</td>
                                <td>{{ $item->pegawai->nip }}</td>
                                <td>{{ $item->pegawai->nama }}</td>
                                <td>{{ $item->jenis_berkas }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->updated_at)) }}</td>
                                <td>
                                    <a href="{{asset('storage/' . $item->file)}}" class="btn-circle btn-sm btn-primary" target="_blank"><i class="fas fa-eye fa-sm"></i></a>
                                    <button class="btn-circle btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit fa-sm"></i></button>
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