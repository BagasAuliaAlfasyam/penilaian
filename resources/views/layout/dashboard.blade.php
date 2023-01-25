<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>E-Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />


    <!-- link datatable -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">


    <link href="{{ asset('plugins/bootstrap5_dashboard/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- csrf-token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand" style="background-color:white;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ url('/dashboard') }}" style="color:#5034FF;"><b>SMA Negeri 7 <br> Lhokseumawe</b></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"
                style="color:#ABABAB;"></i></button>

        <div class="navbar-nav ms-auto me-3">
            <a href="{{ url('/logout') }}" class="btn btn-primary" style="border-radius:20px;font-weight:bold;">Logout</a>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion side-bg-edited" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        @if (Auth::user()->role == 'admin')
                            <a class="nav-link nav-link-edited {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                                <div class="link-side d-flex">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </div>
                            </a>

                            <a class="nav-link nav-link-edited collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                                aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Master Data
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested">
                                    <a id="guru_active" class="nav-link nav-link-edited {{ Request::is('guru') ? 'active' : '' }}"
                                        href="{{ url('guru') }}">
                                        <div class="link-side d-flex">
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-people-group"></i></div>
                                            Guru
                                        </div>
                                    </a>
                                    <a id="siswa_active" class="nav-link nav-link-edited {{ Request::is('siswa') ? 'active' : '' }}"
                                        href="{{ url('siswa') }}">
                                        <div class="link-side d-flex">
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></i></div>
                                            Siswa
                                        </div>
                                    </a>
                                    <a id="mapel_active" class="nav-link nav-link-edited {{ Request::is('mata_pelajaran') ? 'active' : '' }}"
                                        href="{{ url('mata_pelajaran') }}">
                                        <div class="link-side d-flex">
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                            Mata Pelajaran
                                        </div>
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link nav-link-edited {{ Request::is('tahun_pelajaran') ? 'active' : '' }}"
                                href="{{ url('tahun_pelajaran') }}">
                                <div class="link-side d-flex">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                                    Tahun Pelajaran
                                </div>
                            </a>
                            <a class="nav-link nav-link-edited {{ Request::is('wali_kelas') ? 'active' : '' }}" href="{{ url('wali_kelas') }}">
                                <div class="link-side d-flex">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-people-group"></i></div>
                                    Wali Kelas
                                </div>
                            </a>
                        @endif

                        @if (Auth::user()->role == 'guru' || Auth::user()->role == 'wali_kelas')
                            <a class="nav-link nav-link-edited {{ Request::is('penilaian') ? 'active' : '' }}" href="{{ url('penilaian') }}">
                                <div class="link-side d-flex">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file-pen"></i></div>
                                    Penilaian
                                </div>
                            </a>

                            @if (Auth::user()->role == 'wali_kelas')
                                <a class="nav-link nav-link-edited {{ Request::is('kelasku') ? 'active' : '' }}" href="{{ url('kelasku') }}">
                                    <div class="link-side d-flex">
                                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person"></i></div>
                                        Kelasku
                                    </div>
                                </a>
                            @endif
                        @endif

                        <a class="nav-link nav-link-edited {{ Request::is('ubah_password') ? 'active' : '' }}" href="{{ url('ubah_password') }}">
                            <div class="link-side d-flex">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
                                Ubah Password
                            </div>
                        </a>
                        <a class="nav-link nav-link-edited" href="{{ url('/logout') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main style="background-color:#F3F0FF;min-height:90%;padding-bottom:30px;">
                @yield('konten')
            </main>
            <footer class="py-4 mt-auto" style="background-color:white;">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; <b>Diky Satria Ramadanu</b> 2022</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('plugins/bootstrap5_dashboard/js/scripts.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="{{ asset('plugins/bootstrap5_dashboard/assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap5_dashboard/assets/demo/chart-bar-demo.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('plugins/bootstrap5_dashboard/js/datatables-simple-demo.js') }}"></script>

    <!-- jquery -->
    <script src="{{ asset('plugins/jquery/jquery.js') }}"></script>

    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- sweetalert -->
    <script src="{{ asset('plugins/sweetalert/sweetalert.js') }}"></script>
    <script>
        // toast success
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            iconColor: 'green',
            background: 'rgb(91, 255, 96)'
        })

        // toast fail
        const toastFail = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            iconColor: 'green',
            background: 'rgb(255, 71, 71)'
        })


        // link active guru
        let guru_active = $('#guru_active')
        if (guru_active.hasClass('active')) {
            $('#collapseLayouts').addClass('show')
        }
        // link active siswa
        let siswa_active = $('#siswa_active')
        if (siswa_active.hasClass('active')) {
            $('#collapseLayouts').addClass('show')
        }
        // link active mapel
        let mapel_active = $('#mapel_active')
        if (mapel_active.hasClass('active')) {
            $('#collapseLayouts').addClass('show')
        }
    </script>

    @stack('script')
</body>

</html>
