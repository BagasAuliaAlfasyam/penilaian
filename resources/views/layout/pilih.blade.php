<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css ku -->
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">

    <title>user</title>
  </head>
  <body>
    
    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color:white;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="color:#5034FF;"><b>e-Voting</b></a>
            <button class="navbar-toggler" type="button" style="color:#ABABAB;" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="color:#ABABAB;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto" style="font-size:14px;">
                <a class="nav-link px-3 {{ Request::is('pilih') ? 'active' : '' }}" href="{{ url('pilih') }}">Pemilihan</a>
                <a class="nav-link px-3" href="#">Riwayat</a>
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Diky
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size:14px;">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="#">Ubah Password</a></li>
                        <li><hr class="dropdown-divider" style="color:#5034FF;"></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
            </div>
            </div>
        </div>
    </nav>
    <!-- akhir navbar -->

    <!-- konten -->
    <div class="container" style="margin-top:56px;">
        <div class="row">
            <div class="col text-center">
                <h1 style="font-size:20px;margin:30px 0;">Pemilihan Osis Periode 2022/2023</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 style="font-size:25px;text-align:center;">01</h1>
                <div class="cover-gambar">
                    <center><img src="{{ asset('carousel-img/car3.png') }}"></center>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm btn-success">Visi Misi</button>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary mt-3">Pilih</button>
                </div>
            </div>
            <div class="col">
                <h1 style="font-size:25px;text-align:center;">02</h1>
                <div class="cover-gambar">
                    <center><img src="{{ asset('carousel-img/car1.png') }}"></center>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm btn-success">Visi Misi</button>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary mt-3">Pilih</button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <h1 style="font-size:25px;text-align:center;">01</h1>
            </div>
            <div class="col-11" style="margin-top:10px;">
                <div class="progress">
                    <div class="progress-bar" style="width: {{$data1}}%" role="progressbar" aria-valuenow="{{ $data1 }}" aria-valuemin="0" aria-valuemax="100">{{ $data1 }}%</div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <h1 style="font-size:25px;text-align:center;">02</h1>
            </div>
            <div class="col-11" style="margin-top:10px;">
                <div class="progress">
                    <div class="progress-bar" style="width: {{$data2}}%" role="progressbar"     aria-valuenow="{{ $data2 }}" aria-valuemin="0" aria-valuemax="100">{{ $data2 }}%</div>
                </div>
            </div>
        </div>
    </div>
    <!-- akhir konten -->




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>