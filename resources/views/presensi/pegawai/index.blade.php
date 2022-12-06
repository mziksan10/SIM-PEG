@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="card shadow text-center mb-4">
        <div class="card-header">
            <small class="text-muted"><i>Hallo {{ ucwords(session()->get('nama')) }}!</i></small>
        </div>
        <div class="card-body">
            <img class="img-thumbnail rounded-circle mb-3 mt-3" style="width:100px; height:100px" src="{{asset('storage/' . session()->get('foto'))}}">
            <h1 id="jam" class="card-title"></h1>
            <p class="card-text">{{ date('l, d F Y') }}</p>
            @if($presensi == null)
            <form action="/presensi-pegawai" method="POST">
            @csrf
            <button class="btn btn-primary mb-4" type="submit">Absen Masuk</button>
            </form>
            @elseif($presensi->keterangan == null)
            <form action="/presensi-pegawai" method="POST">
            @method('put')
            @csrf
            <button class="btn btn-danger mb-4" type="submit">Absen Pulang</button>
            </form>
            @elseif($presensi->keterangan != null)
            <!-- Kosong -->
            @endif
            <div class="table-responsive container">
            <table class="table" width="100%" cellspacing="0">
                    <tr>
                        <th>Tanggal</th>
                        <th style="text-align: center">Jam Masuk</th>
                        <th style="text-align: center">Jam Keluar</th>
                        <th style="text-align: center">Status</th>
                        <th style="text-align: center">Keterangan</th>
                    </tr>
                    @foreach($data_presensi as $item)
                    <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td style="text-align: center">{{ $item->jam_masuk }}</td>
                    <td style="text-align: center">{{ $item->jam_keluar }}</td>
                    <td style="text-align: center">{{ $item->status }}</td>
                    <td style="text-align: center">{{ $item->keterangan }}</td>
                    </tr>
                    @endforeach
            </table>
            </div>
        </div>
        <div class="card-footer">
        @if(session()->has('success'))
            <small class="text-success"><i>{{ session('success') }}</i></small>
        @elseif(session()->has('failed'))
            <small class="text-danger"><i>{{ session('failed') }}</i></small>
        @else
            <small class="text-muted"><i>Semoga harimu menyenangkan :)</i></small>
        @endif
        </div>
        </div>
    </div>
</div>

@endsection