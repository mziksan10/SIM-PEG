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
                            <th style="text-align: center">Sesi</th>
                            <th style="text-align: center">Jam Masuk</th>
                            <th style="text-align: center">Jam Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_aturanPresensi as $item)
                        <tr>
                            <td>{{  $loop->iteration }}</td>
                            <td>{{ $item->sesi }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td style="text-align: center">{{ $item->jam_masuk + (0 * 60*0 * 60 * 8) }}</td>
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