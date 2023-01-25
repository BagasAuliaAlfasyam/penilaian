@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Tambah Guru</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('guru') }}">guru</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('guru/tambah') }}">tambah guru</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-5 bg-table">

                <form action="" id="form-tambah-guru">
                    <div class="form-group mb-3">
                        <label>NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="text" name="email" id="email" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control fc-edited">
                            <option value="">----</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control fc-edited"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control fc-edited">
                    </div>
                    <button class="btn btn-sm btn-primary float-end d-flex" id="btn-tam-guru">
                        <div>Tambah</div>
                        <svg id="loading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px"
                            viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <g>
                                <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12">
                                </path>
                                <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s"
                                    values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                            </g>
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // ajax toke setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // tambah guru
            $(document).on('submit', '#form-tambah-guru', function(e) {
                e.preventDefault()

                // hapus validasi
                var form = $('#form-tambah-guru')
                form.find('.form-text').remove()

                // animasi
                let btn = document.getElementById('btn-tam-guru')
                btn.setAttribute('disabled', true)
                let loading = document.getElementById('loading')
                loading.style.display = 'block'

                let formData = new FormData($('#form-tambah-guru')[0])

                $.ajax({
                    type: "POST",
                    url: "/guru/tambah",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function() {

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Guru berhasil ditambahkan'
                        })

                        setTimeout(() => {
                            window.location.href = '/guru'
                        }, 1000)
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, value) {
                                $('#' + key)
                                    .closest('.form-group')
                                    .append("<div class='form-text text-danger'>" + value + "</div>")

                                // hilangkan animasi
                                loading.style.display = 'none'
                                btn.removeAttribute('disabled', false)
                            })
                        }
                    }
                })
            })

        })
    </script>
@endpush
