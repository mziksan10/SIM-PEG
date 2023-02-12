<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('/assets/img') }}/logo_piksi.png" alt="" class="img" style="height:30px">
        </div>
        <div class="sidebar-brand-text mx-3">SIMPEG PIKSI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('/dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if(auth()->user()->role == 'user')
    <li class="nav-item {{ request()->is('profil*') ? 'active' : '' }}">
        <a class="nav-link" href="/profil">
            <i class="fas fa-user"></i>
            <span>Profil</span></a>
    </li>
    <li class="nav-item {{ request()->is('pemberkasan-pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="/pemberkasan-pegawai">
            <i class="fas fa-paper-plane"></i>
            <span>Pemberkasan</span></a>
    </li>
    <li class="nav-item {{ request()->is('presensi-pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="/presensi-pegawai">
            <i class="fas fa-paper-plane"></i>
            <span>Presensi</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#setting" aria-expanded="true" aria-controls="setting">
            <i class="fas fa-user-cog"></i>
            <span>Setting</span>
        </a>
        <div id="setting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="#">Ganti Foto</a>
                <a class="collapse-item" href="#">Reset Password</a>
            </div>
        </div>
    </li>
    @endif

    @if(auth()->user()->role == 'admin')
    @if(request()->is('pegawai*') || request()->is('golongan*') || request()->is('bidang*') || request()->is('jabatan*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed collapsed" href="#" data-toggle="collapse" data-target="#master-data" aria-expanded="false" aria-controls="master-data">
            <i class="fas fa-database"></i>
            <span>Data Master</span>
        </a>
        <div id="master-data" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="/pegawai">Data Pegawai</a>
                <a class="collapse-item" href="/golongan">Data Golongan</a>
                <a class="collapse-item" href="/bidang">Data Bidang</a>
                <a class="collapse-item" href="/jabatan">Data Jabatan</a>
            </div>
        </div>
        
    </li>
    @if(request()->is('riwayat-jabatan*') || request()->is('riwayat-pendidikan*') || request()->is('riwayat-pemberkasan*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kelola-riwayat" aria-expanded="false" aria-controls="kelola-riwayat">
        <i class="fas fa-user-cog"></i>
            <span>Kelola Kepegawaian</span>
        </a>
        <div id="kelola-riwayat" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="/riwayat-pendidikan">Riwayat Pendidikan</a>
                <a class="collapse-item" href="/riwayat-jabatan">Riwayat Jabatan</a>
                <a class="collapse-item" href="/riwayat-pemberkasan">Riwayat Pemberkasan</a>
            </div>
        </div>
        
    </li>
    @if(request()->is('aturan-presensi*') || request()->is('rekap-presensi*'))
    <li class="nav-item active">
    @else
    <li class="nav-item">
    @endif
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kelola-presensi" aria-expanded="false" aria-controls="kelola-presensi">
        <i class="fas fa-clock"></i>
            <span>Kelola Presensi</span>
        </a>
        <div id="kelola-presensi" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub menu:</h6>
                <a class="collapse-item" href="/aturan-presensi">Aturan Presensi</a>
                <a class="collapse-item" href="/rekap-presensi">Rekap Presensi</a>
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
                <a class="collapse-item" href="/user">User & Role</a>
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