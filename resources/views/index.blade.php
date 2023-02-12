@extends('layouts/main')
@section('container')
    <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
</div>

<!-- Content Row -->
@if(session()->has('success'))                                
<div class="alert alert-success alert-dismissible fade show" role="alert">
@if(session()->get('nama') === null)
    <small>{{ session('success') }} <b>{{ ucwords(auth()->user()->username) }} !</b> anda login sebagai <b>{{ auth()->user()->role }}</b>.</small>
@elseif(session()->get('nama'))
<small>{{ session('success') }} <b>{{ ucwords(session()->get('nama')) }} !</b> anda login sebagai <b>{{ auth()->user()->role }}</b>.</small>
@endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(session()->has('failed')) 
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <small>{{ session('failed') }}</small>
</div>
@endif

@if(auth()->user()->role == 'admin')
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pegawai Tetap</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data_pegawai_tetap }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pegawai Kontrak</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data_pegawai_kontrak }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total pegawai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data_pegawai_total }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart data pegawai -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="chartPegawai"></div>
            </div>
        </div>
    </div>
</div>
@endif


<!-- Content Row -->
<div class="row">
    <div class="col">
    <!-- Illustrations -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">SIMPEG PIKSI</h6>
        </div>
        <div class="card-body">
            <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 50%;"
                    src="{{ asset('assets/img') }}/bg_dashboard.jpg" alt="...">
            </div>
            <p  style="text-align:center;">SIMPEG PIKSI adalah suatu sistem yang dibuat untuk mempermudah pengelolaan sistem tatakelola administrasi kepegawaian di Politeknik Piksi Ganesha dengan menggunakan sistem berbasis web.</p>
        </div>
    </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('chartPegawai', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'LAPORAN DATA PEGAWAI'
    },
    subtitle: {
        text: 'Politeknik Piksi Ganesha'
    },
    xAxis: {
        categories: {!!json_encode($categories)!!},
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pegawai'
        }
    },
    tooltip: {
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Total Jumlah Pegawai',
        data: {!!json_encode($series)!!}

    }]
});
</script>
@endsection