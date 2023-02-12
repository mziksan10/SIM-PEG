@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="/pegawai" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

<!-- Content Row -->
<div class="row">
    <div class="col">
    @if(date('d F', strtotime($pegawai->tanggal_lahir)) == date('d F', strtotime(now())) )
        <div class="card shadow mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-1">
                    <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="col-11">
                        <marquee><small><i class="fas fa-gift"></i> Hari ini <b>{{ $pegawai->nama }}</b> Berulang Tahun yang ke- {{ date('Y', strtotime(now())) - date('Y', strtotime($pegawai->tanggal_lahir)) }} Tahun.</small></marquee>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-8 d-flex justify-content-start">
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-user"></i> Detail Pribadi</h6>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <a href="/pegawai/{{ $pegawai->id }}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit fa-sm"></i> Edit</a>
                            <form action="/pegawai/{{ $pegawai->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-sm btn-danger border-0" onclick="return confirm('Apakah kamu yakin?')"><i class="fas fa-trash fa-sm"></i> Delete</button>
                            </form>
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
                                    <td>: {{ $pegawai->alamat . " " . $pegawai->desa . ", " . $pegawai->kecamatan . " " . $pegawai->kab_kota . " " . $pegawai->provinsi . " " . $pegawai->kode_pos}}</td>
                                </tr>
                                <tr>
                                    <th>No. Handphone</th>
                                    <td>: {{ $pegawai->no_hp }} <a href="https://wa.me/62{{ $pegawai->no_hp }}" class="btn-circle btn-sm btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a></td>
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
                                            <th>Gaji Pokok</th>
                                            @if($pegawai->riwayatJabatan === null)
                                            <td>: -</td>
                                            @elseif($pegawai->riwayatJabatan)
                                            <td>: Rp. {{ number_format($pegawai->riwayatJabatan->golongan->gaji_pokok, 2,',','.') }},-</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <td>: {{ $pegawai->tanggal_masuk }}</td>
                                        </tr>
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
                                        <tr>
                                            <th>Lama Bekerja</th>
                                            <td>: {{ $thn." tahun ".$bln." bulan ".$tgl." hari" }}</td>
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
                                        @endif
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
                        <h6 class="font-weight-bold text-primary mt-auto"><i class="fas fa-history"></i> Riwayat Pendidikan</h6>
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
        
        @if(session()->has('success'))                                
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <small>{{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <form action="/berkas" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
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
                    <a href="/pegawai/{{ $pegawai->id }}" class="btn btn-primary mr-2"><i class="fas fa-sync fa-sm"></i></a>
                    <h6 class="font-weight-bold text-primary mt-auto">Data Pemberkasan</h6>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <form action="/pegawai/{{ $pegawai->id }}" method="GET">
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