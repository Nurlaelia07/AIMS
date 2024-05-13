    <!-- Sidebar -->
    <ul class="navbar-nav sidebar mt-1 mb-1 ms-1 me-1 sidebar-dark accordion" style="background-color: #23AF4F; border-radius: 25px" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <!-- <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div> -->
            <div class="sidebar-brand-text mx-3" style="font-size: 25px">AIMS<sup></sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link text-center" href="{{ url('/home') }}">
                <span>Home</span></a>
        </li> 
        
        <li class="nav-item {{ Request::is('suhu') || Request::is('riwayat-suhu') ? 'active' : '' }}">
            <a class="nav-link text-center" href="{{ url('suhu') }}">
                <span>Suhu</span></a>
        </li> 
        <li class="nav-item {{ Request::is('ph') || Request::is('riwayat-ph') ? 'active' : '' }}">
            <a class="nav-link text-center" href="{{ url('ph') }}">
                <span>Ph Air</span></a>
        </li> 
        <li class="nav-item {{ Request::is('ppm') || Request::is('riwayat-ppm') ? 'active' : '' }}">
            <a class="nav-link text-center" href="{{ url('ppm') }}">
                <span>PPM</span></a>
        </li> 

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->