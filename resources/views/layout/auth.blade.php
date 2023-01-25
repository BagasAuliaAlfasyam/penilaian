<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css ku -->
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">

    <title>E-Nilai - Login</title>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color:white;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/dashboard') }}" style="color:#5034FF;"><b>SMA Negeri 7 Lhokseumawe</b></a>
        </div>
    </nav>
    <!-- akhir navbar -->

    <!-- konten -->
    <div class="container" style="margin-top:56px;">
        <div class="row" style="height:90vh;">
            <div class="col-md-8 gambar">
                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel"
                    style="height:100%;display:flex;align-items:center;">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true"
                            aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="4000">
                            <center><img src="{{ asset('carousel-img/img1.png') }}" draggable="false"></center>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <center><img src="{{ asset('carousel-img/img2.png') }}" draggable="false"></center>
                        </div>
                        <div class="carousel-item">
                            <center><img src="{{ asset('carousel-img/img3.png') }}" draggable="false"></center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 form" style="height:100%;">
                <div class="row" style="height:100%;align-items:center;">
                    <div class="col bg-table">
                        <img src="{{ asset('carousel-img/img1.png') }}" alt="" class="mobile">
                        <div class="text-center" style="margin-bottom:35px;">
                            <h4>Login</h4>
                        </div>
                        <!-- <hr style="border:2px solid #5034FF;background-color:#5034FF;color:#5034FF;"> -->
                        <form action="{{ url('/store') }}" method="post">

                            @csrf
                            @if ($gagal = session()->get('message'))
                                <div class="alert alert-danger">
                                    {{ $gagal }}
                                </div>
                            @endif

                            @if ($logout = session()->get('logout'))
                                <div class="alert alert-success">
                                    {{ $logout }}
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control fc-edited">
                                @error('username')
                                    <div class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control fc-edited">
                                @error('password')
                                    <div class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn btn-sm btn-primary float-end">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- akhir konten -->




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>
