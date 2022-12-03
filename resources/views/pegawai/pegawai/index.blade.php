@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

<!-- Content Row -->
<div class="row">
    <div class="col">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-user"></i> Detail Pribadi</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <!-- Kosong -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3">
                            @if($pegawai->foto)
                            <div style="max-height: 300px; max-width: 250px; overflow: hidden;">
                            <img src="{{asset('storage/' . $pegawai->foto)}}" style="height: 300px; width: 250px;" class="img-thumbnail">
                            </div>
                            @else
                            <div style="max-height: 300px; max-width: 250px; overflow: hidden;">
                            <img src="{{asset('/assets/img/user_default.png')}}" style="height: 300px; width: 250px;" class="img-thumbnail">
                            </div>
                            @endif
                        </div>
                        <div class="col-9">
                            <table class="table small">
                                <tr>
                                    <th>Nama</th>
                                    <td>: {{ $pegawai->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal lahir</th>
                                    <td>: {{ $pegawai->tempat_lahir . ", " . date('d F Y', strtotime($pegawai->tanggal_lahir)) }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    @if ($pegawai->jenis_kelamin == "L")
                                    <td>: Laki-laki</td>
                                    @elseif ($pegawai->jenis_kelamin == "P")
                                    <td>: Perempuan</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $pegawai->alamat . " " . $pegawai->desa . ", " . $pegawai->kecamatan . " " . $pegawai->kab_kota . " " . $pegawai->provinsi . " " . $pegawai->kode_pos}}</td>
                                </tr>
                                <tr>
                                    <th>No. Handphone</th>
                                    <td>: {{ $pegawai->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: {{ $pegawai->email }}</td>
                                </tr>
                            </table>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start">
                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-briefcase"></i> Detail Jabatan</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <table class="table small">
                                        <tr>
                                            <th>NIP</th>
                                            <td>: {{ $pegawai->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bidang</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>-</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ $pegawai->riwayatJabatan->bidang->nama_bidang }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>-</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: {{ $pegawai->riwayatJabatan->jabatan->nama_jabatan }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Golongan</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>-</td>
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
                                            <th>Gaji Pokok</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>-</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: Rp. {{ number_format($pegawai->riwayatJabatan->golongan->gaji_pokok, 2,',','.') }},-</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <td>: {{ $pegawai->tanggal_masuk }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            @if( $pegawai->status == 'Aktif')
                                            <td>: <div class="badge badge-success ">Aktif</div></td>
                                            @elseif( $pegawai->status == 'Non Aktif')
                                            <td>: <div class="badge badge-danger">Non Aktif</div></td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start">
                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-graduation-cap"></i> Detail Pendidikan</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <table class="table small">
                                        <tr>
                                            <th>Pendidikan Terakhir</th>
                                            <td>: {{ $pegawai->pendidikan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurusan</th>
                                            <td>: {{ $pegawai->jurusan }}</td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start">
                                <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-university"></i> Detail Bank</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <table class="table small">
                                        <tr>
                                            <th>Nama Bank</th>
                                            <td>: {{ $pegawai->bank }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Rekening</th>
                                            <td>: {{ $pegawai->no_rekening }}</td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-history"></i> Riwayat Jabatan</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <!-- Kosong -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
              <table class="table small">
                    <tr>
                        <th>No</th>
                        <th>Bidang</th>
                        <th>jabtan</th>
                        <th>Golongan</th>
                        <th>Tanggal SK</th>
                    </tr>
              @foreach($data_riwayatJabatan as $item)
                    <tr>
                        <td>{{ $loop->iteration . "." }}</td>
                        <td>{{ $item->bidang->nama_bidang }}</td>
                        <td>{{ $item->jabatan->nama_jabatan }}</td>
                        <td>{{ $item->golongan->golongan . "-" . $item->golongan->status}}</td>
                        <td>{{ $item->tanggal_sk }}</td>
                    </tr>
              @endforeach
                </table>
            </div>
        </div>
        
        @if(session()->has('success'))                                
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <small>{{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    <!-- DataTales Example -->
    </div>
</div>
@endsection