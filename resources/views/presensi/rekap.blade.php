@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="form-col">
<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>
<div class="form-col">
<form action="/export/presensi" method="GET">
@csrf
<div class="input-group">
<a href="/rekap-presensi" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
<div class="input-group-prepend">
    <span class="input-group-text ml-2">From</span>
</div>
<input type="date" class="form-control col-4" name="fromDate">
<div class="input-group-prepend">
    <span class="input-group-text">To</span>
</div>
<input type="date" class="form-control col-4" name="toDate">
<div class="input-group-append">
<button type="submit" class="btn btn-success"><i class="fas fa-file-excel fa-sm"></i> Export</button>
</div>
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
        <div class="card-body">
        <div class="table-responsive">
            <table id="myTable">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th style="text-align: center">No</th>
                            <th style="text-align: center">NIP</th>
                            <th style="text-align: center">Nama</th>
                            <th style="text-align: center">Tanggal</th>
                            <th style="text-align: center">Jam Masuk</th>
                            <th style="text-align: center">Jam Keluar</th>
                            <th style="text-align: center">Sesi</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_presensi as $item)
                        <tr>
                            <td>{{  $loop->iteration }}</td>
                            <td>{{ $item->pegawai->nip }}</td>
                            <td>{{ $item->pegawai->nama }}</td>
                            <td style="text-align: center">{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                            <td style="text-align: center">{{ $item->jam_masuk }}</td>
                            <td style="text-align: center">{{ $item->jam_keluar }}</td>
                            <td style="text-align: center">{{ $item->sesi }}</td>
                            <td style="text-align: center">{{ $item->status }}</td>
                            <td style="text-align: center">{{ $item->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection