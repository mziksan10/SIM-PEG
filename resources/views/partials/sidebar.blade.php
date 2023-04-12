<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('/assets/img') }}/logo_piksi.png" alt="" class="img" style="height:40px">
        </div>
        <div class="sidebar-brand-text mx-2">
        <img src="{{ asset('/assets/img') }}/text-simpeg.png" alt="" class="img" style="width:100%">
        </div>
    </a> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider my-0"> -->

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('/*') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if(auth()->user()->role == 'user')
    <li class="nav-item {{ request()->is('profil*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profil') }}">
            <i class="fas fa-user"></i>
            <span>Profil</span></a>
    </li>
    <li class="nav-item {{ request()->is('pemberkasan-pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pemberkasan') }}">
            <i class="fas fa-folder-open"></i>
            <span>Pemberkasan</span></a>
    </li>
    <li class="nav-item {{ request()->is('presensi-pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('presensi') }}">
        <i class="fas fa-user-clock"></i>
            <span>Presensi</span></a>
    </li>
    <li class="nav-item {{ request()->is('reset-password*') ? 'active' : '' }}">
        <a class="nav-link" href="#">
        <i class="fas fa-key"></i>
            <span>Reset Password</span></a>
    </li>
    @elseif(auth()->user()->role == 'admin')
    <li class="nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pegawai') }}">
            <i class="fas fa-users"></i>
            <span>Data Pegawai</span></a>
    </li>
    @if(request()->is('golongan*') || request()->is('bidang*') || request()->is('jabatan*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed collapsed" href="#" data-toggle="collapse" data-target="#master-data" aria-expanded="false" aria-controls="master-data">
            <i class="fas fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="master-data" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="/golongan"><i class="fas fa-chevron-circle-right mr-1"></i>Data Golongan</a>
                <a class="collapse-item" href="/bidang"><i class="fas fa-chevron-circle-right mr-1"></i>Data Bidang</a>
                <a class="collapse-item" href="/jabatan"><i class="fas fa-chevron-circle-right mr-1"></i>Data Jabatan</a>
            </div>
        </div>
        
    </li>

    @if(request()->is('presensi*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#presensi" aria-expanded="false" aria-controls="presensi">
            <i class="fas fa-user-clock"></i>
            <span>Presensi</span>
        </a>
        <div id="presensi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="{{ route('aturanPresensi') }}"><i class="fas fa-chevron-circle-right mr-1"></i>Aturan Presensi</a>
                <a class="collapse-item" href="{{ route('rekapPresensi') }}"><i class="fas fa-chevron-circle-right mr-1"></i>Rekap Presensi</a>
            </div>
        </div>
    </li>

    @if(request()->is('user*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#setting" aria-expanded="false" aria-controls="setting">
            <i class="fas fa-cog"></i>
            <span>Setting</span>
        </a>
        <div id="setting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="/user"><i class="fas fa-chevron-circle-right mr-1"></i>User & Role</a>
            </div>
        </div>
    </li>
    @endif
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->