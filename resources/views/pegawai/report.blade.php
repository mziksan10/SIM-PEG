<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Pegawai {{ date('Y') }}</title>
    <style>
        table{
            width: 100%;
            margin-bottom: 30px;
        }
        
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 10px;
        text-align: center;
        }

        #ttd, #ttd td {
            border: 0px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <img src="{{public_path('/storage/kop_piksi.jpeg')}}" class="img-thumbnail" style="max-width: 700px">
    <center>
        <h3 style="margin-bottom: 0px">LAPORAN DATA PEGAWAI {{ date('Y') }}</h3>
        <p style="margin-TOP: 0px">Politeknik Piksi Ganesha</p>
    </center>
    <table>
        <tr style="background-color: yellow">
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Bidang</th>
            <th>Jabatan</th>
            <th>Golongan</th>
            <th>Gaji Pokok</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
        @foreach ($data_pegawai as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nip }}</td>
            <td>{{ $item->nama }}</td>
            @if( $item->riwayatJabatan == null)
            <td></td><td></td><td></td><td></td>
            @elseif( $item->riwayatJabatan)
            <td>{{ $item->riwayatJabatan->bidang->nama_bidang }}</td>
            <td>{{ $item->riwayatJabatan->jabatan->nama_jabatan }}</td>
            <td>{{ $item->riwayatJabatan->golongan->golongan . ' - ' . $item->riwayatJabatan->golongan->status  }}</td>
            <td>Rp. {{ number_format($item->riwayatJabatan->golongan->gaji_pokok, 2,',','.') }}</td>
            @endif
            <td>{{ $item->tanggal_masuk }}</td>
            @if( $item->status == 'Aktif')
            <td>Aktif</td>
            @elseif($item->status == 'Non Aktif')
            <td>Non Aktif</td>
            @endif
        </tr>
        @endforeach
    </table>

    <table id="ttd">
        <tr>
            <td colspan="2">Bandung, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="2">Mengetahui,</td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u><b>DR. H. K. PRIHARTONO AH., MM., MOS., CMA., MPM</b></u><br>
                <small>Direktur</small>
            </td>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <u><b>Hambali Ahmad Aripin, S,ST., M.M</b></u><br>
                <small>Wakil Direktur II Bid. Keuangan dan Umum</small>
            </td>
        </tr>
    </table>
</body>
</html>