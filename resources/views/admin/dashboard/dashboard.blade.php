@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="">Dashboard</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="bg-card mb-4">
                    <div class="left-card">
                        <div class="cover-icon-dashboard">
                            <!-- <i class="fa-solid fa-person"></i> -->
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                    </div>
                    <div class="right-card" style="padding-left:20px;">
                        <p style="font-size:16px;">Guru</p>
                        <h2 style="margin:0;padding:0;"><b>{{ $guru }}</b></h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="bg-card mb-4">
                    <div class="left-card">
                        <div class="cover-icon-dashboard">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="right-card" style="padding-left:20px;">
                        <p style="font-size:16px;">Siswa</p>
                        <h2 style="margin:0;padding:0;"><b>{{ $siswa }}</b></h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="bg-card mb-4">
                    <div class="left-card">
                        <div class="cover-icon-dashboard">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                    <div class="right-card" style="padding-left:20px;">
                        <p style="font-size:16px;">Mata Pelajaran</p>
                        <h2 style="margin:0;padding:0;"><b>{{ $mapel }}</b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
