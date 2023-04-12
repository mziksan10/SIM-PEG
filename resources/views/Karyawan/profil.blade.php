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
<!-- belum ada -->
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
    @endif
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow-sm mb-2">
        <div class="card border-left-primary">
            <div class="card-body px-1 py-1">
                <div class="form-row">
                    <div class="col-xl-1 col-md-2">
                    <div class="badge badge-primary py-2" style="width:100%">
                    <i class="fas fa-bullhorn mr-2"></i> Info
                    </div>
                    </div>
                    <div class="col-xl-11 col-md-10 modal-dialog-centered">
                    <marquee>
                    <?php
                        $tanggal_masuk = new DateTime("$pegawai->tanggal_masuk");
                        $sekarang = new DateTime("today");
                        if ($tanggal_masuk > $sekarang) { 
                        $thn = "0";
                        $bln = "0";
                        $tgl = "0";
                        }
                        $thn = $sekarang->diff($tanggal_masuk)->y;
                        $bln = $sekarang->diff($tanggal_masuk)->m;
                        $tgl = $sekarang->diff($tanggal_masuk)->d;
                    ?>   
                        @if($pegawaiBerulangTahun == false)
                        <small><b>Tanggal Masuk</b> : {{ $pegawai->tanggal_masuk }} | <b>Lama Bekerja</b> : {{ $thn." Tahun " . $bln." Bulan ".$tgl." Hari" }}</small>
                        @else
                            @if(date('d F', strtotime($pegawai->tanggal_lahir)) == date('d F', strtotime(now())) )
                            <small class="ml-3"><i class="fas fa-gift"></i> Hari ini anda Berulang Tahun yang ke- {{ date('Y', strtotime(now())) - date('Y', strtotime($pegawai->tanggal_lahir)) }} Tahun.</small>
                            @endif
                        <small><b>Tanggal Masuk</b> : {{ $pegawai->tanggal_masuk }} | <b>Lama Bekerja</b> : {{ $thn." Tahun " . $bln." Bulan ".$tgl." Hari" }}</small>
                        @endif
                    </marquee>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow-sm mb-2">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-user"></i> Detail Pribadi</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <a href="{{ route('editProfil', $pegawai->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit fa-sm"></i> Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                    <div class="form-row">
                        <div class="col-xl-2 col-md-6">
                        <div class="img-thumbnail modal-dialog-centered justify-content-center bg-light mb-3">
                            <div style="max-height: 500px; max-width: 250px; overflow: hidden;">
                            @if($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-preview mb-2" style="height: 300px; width: 250px; overflow: hidden;">
                            @elseif(!$pegawai->foto)
                            <img src="{{ asset('assets/img') }}/user_default.png" class="img-preview mb-2" style="height: 300px; width: 250px; overflow: hidden;">
                            @endif
                            <div class="card text-center">
                                NIP. {{ $pegawai->nip }}
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-10 col-md-6">
                            <table class="table small">
                                <tr>
                                    <th>NIK</th>
                                    <td>: {{ $pegawai->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>: {{ $pegawai->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal lahir</th>
                                    <td>: {{ ucwords(strtolower($pegawai->tempat_lahir)) . ", " . date('d F Y', strtotime($pegawai->tanggal_lahir)) }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>: {{ $pegawai->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $pegawai->alamat . " " . ucwords(strtolower($pegawai->subdistricts->subdis_name)) . ", " . ucwords(strtolower($pegawai->cities->city_name)) . " " . ucwords(strtolower($pegawai->districts->dis_name)) . " " . ucwords(strtolower($pegawai->provinces->prov_name)) . " " . $pegawai->kode_pos  }}</td>
                                </tr>
                                <tr>
                                    <th>No. Handphone</th>
                                    <td>: {{ $pegawai->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: {{ $pegawai->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pernikahan</th>
                                    <td>: {{ $pegawai->status_pernikahan }}</td>
                                </tr>
                            </table>
                        </div>
                      </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start">
                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-briefcase"></i> Detail Jabatan</h6>
                            </div>
                            <div class="col-4">
                                <div class="float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="form-row">
                                <div class="col">
                                    <table class="table small">
                                        <tr>
                                            <th>NIP</th>
                                            <td>: {{ $pegawai->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bidang</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>: -</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ ucwords(strtolower($pegawai->riwayatJabatan->bidang->nama_bidang)) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>: -</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ ucwords(strtolower($pegawai->riwayatJabatan->jabatan->nama_jabatan)) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Golongan</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>: -</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ $pegawai->riwayatJabatan->golongan->golongan }}
                                                @if( $pegawai->riwayatJabatan->golongan->status == 'Kontrak')
                                                <div class="badge badge-warning">Kontrak</div>
                                                @elseif( $pegawai->riwayatJabatan->golongan->status == 'Tetap')
                                                <div class="badge badge-primary">Tetap</div>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>TMT Bekerja</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>: -</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ $pegawai->riwayatJabatan->tmt_bekerja }}</td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                              </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-2">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start">
                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-graduation-cap"></i> Detail Pendidikan</h6>
                            </div>
                            <div class="col-4">
                                <div class="float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="form-row">
                                <div class="col">
                                    <table class="table small">
                                    @if($pegawai->riwayatPendidikan === null)
                                            <tr>
                                            <th>Jenjang</th>
                                            <td>: -</td>
                                            </tr>
                                            <tr>
                                            <th>Jurusan</th>
                                            <td>: - </td>
                                            </tr>
                                            <tr>
                                            <th>Nama Institusi</th>
                                            <td>: -</td>
                                            </tr>
                                            <tr>
                                            <th>Tahun Lulus</th>
                                            <td>: -</td>
                                            </tr>
                                    @else
                                        <tr>
                                            <th>Jenjang</th>
                                            <td>: {{ $pegawai->riwayatPendidikan->jenjang }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurusan</th>
                                            <td>: {{ $pegawai->riwayatPendidikan->jurusan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Institusi</th>
                                            <td>: {{ $pegawai->riwayatPendidikan->institusi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun Lulus</th>
                                            <td>: {{ $pegawai->riwayatPendidikan->tahun_lulus }}</td>
                                        </tr>
                                        <tr>
                                            <th>Scan Ijazah</th>
                                            <td>: <a href="{{asset('storage/' . $pegawai->riwayatPendidikan->scan_ijazah)}}" target="_blank" class="badge badge-sm badge-danger ml-1"><i class="fas fa-file-pdf"></i> Show</a></td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                              </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-2">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-history"></i> Riwayat Pendidikan</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                         <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModalPendidikan"><i class="fas fa-plus fa-sm"></i> Add</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table small">
                    <tr>
                        <th>No</th>
                        <th>Jenjang</th>
                        <th>Jurusan</th>
                        <th>Nama Institusi</th>
                        <th>Tahun Lulus</th>
                    </tr>
                    @foreach($data_riwayatPendidikan as $item)
                    <tr>
                        <td>{{ $loop->iteration . "." }}</td>
                        <td>{{ $item->jenjang }}</td>
                        <td>{{ $item->jurusan }}</td>
                        <td>{{ $item->institusi }}</td>
                        <td>{{ $item->tahun_lulus }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>

        <div class="card shadow-sm mb-2">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-history"></i> Riwayat Jabatan</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                        <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModalJabatan"><i class="fas fa-plus fa-sm"></i> Add</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table small">
                    <tr>
                        <th>No</th>
                        <th>Bidang</th>
                        <th>jabatan</th>
                        <th>Golongan</th>
                        <th>TMT Golongan</th>
                        <th>TMT Bekerja</th>
                    </tr>
              @foreach($data_riwayatJabatan as $item)
                    <tr>
                        <td>{{ $loop->iteration . "." }}</td>
                        <td>{{ ucwords(strtolower($item->bidang->nama_bidang)) }}</td>
                        <td>{{ ucwords(strtolower($item->jabatan->nama_jabatan)) }}</td>
                        <td>{{ $item->golongan->golongan . " - " . $item->golongan->status}}</td>
                        <td>{{ $item->tmt_golongan }}</td>
                        <td>{{ $item->tmt_bekerja }}</td>
                    </tr>
              @endforeach
                </table>
            </div>
            </div>
        </div>
</div>
@endsection