@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>
<div class="form-col">
<a href="{{ route('pemberkasan') }}" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
<button type="button" class="btn btn btn-primary shadow ml-1" data-toggle="modal" data-target="#createModalPemberkasan"><i class="fas fa-plus fa-sm"></i> Add</button>
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
            <div class="col">
                <div class="table-responsive">
                <table id="myTable" class="table table-border table-hover">
                            <thead>
                                <tr class="bg-light">
                                    <th>No</th>
                                    <th>Jenis Berkas</th>
                                    <th>Keterangan</th>
                                    <th>Diunggah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                                @foreach($data_berkas as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->jenis_berkas }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ date('d/m/y', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <a href="{{asset('storage/' . $item->file)}}" class="btn-circle btn-sm btn-primary" target="_blank"><i class="fas fa-eye fa-sm"></i></a>
                                        <form action="{{ route('destroyPemberkasan', $item->id) }}" method="post" class="d-inline">
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
</div>
<div class="row">
<div class="col">
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
        <small>
            <b>Perhatian</b>
            <ul>
                <li>Ukuran berkas tidak boleh lebih dari 1 MB.</li>
                <li>Keterangan diisi nama berkas.</li>
                <li>Jenis file harus asli/fotocopy.</li>
                <li>Ekstensi berkas berupa PDF.</li>
            </ul>
        </small>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
</div>
</div>
</div>

@include('karyawan/modal/create-pemberkasan')
@endsection