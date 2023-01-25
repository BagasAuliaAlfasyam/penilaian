@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Edit Siswa</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('siswa') }}">siswa</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('siswa/edit/' . $siswa->id) }}">edit siswa</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-5 bg-table">

                <form action="" id="form-edit-siswa">
                    <input type="hidden" name="id-edit" id="id-edit" value="{{ $siswa->id }}">
                    <div class="form-group mb-3">
                        <label>NISN</label>
                        <input type="text" name="nisn-edit" id="nisn-edit" class="form-control fc-edited" value="{{ $siswa->nisn }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama-siswa-edit" id="nama-siswa-edit" class="form-control fc-edited" value="{{ $siswa->nama_siswa }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Jurusan</label>
                        <select name="jurusan-edit" id="jurusan-edit" class="form-control fc-edited">
                            <option value="IPA" {{ $siswa->jurusan == IPA ? 'selected' : '' }}>IPA</option>
                            <option value="IPS" {{ $siswa->jurusan == IPS ? 'selected' : '' }}>IPS</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kelas</label>
                        <select name="kelas-edit" id="kelas-edit" class="form-control fc-edited">
                            <option value="X" {{ $siswa->kelas == X ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ $siswa->kelas == XI ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ $siswa->kelas == XII ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin-edit" id="jenis_kelamin-edit" class="form-control fc-edited">
                            <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Wali</label>
                        <input type="text" name="nama-wali-edit" id="nama-wali-edit" class="form-control fc-edited" value="{{ $siswa->wali }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Telepon Wali</label>
                        <input type="text" name="telepon_wali-edit" id="telepon_wali-edit" class="form-control fc-edited"
                            value="{{ $siswa->telepon_wali }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea class="form-control fc-edited" name="alamat-edit" id="alamat-edit" rows="3">{{ $siswa->alamat }}</textarea>
                    </div>
                    <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-siswa">
                        <div>Edit</div>
                        <svg id="loading-edit" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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

            // edit siswa
            $(document).on('submit', '#form-edit-siswa', function(e) {
                e.preventDefault()

                // ambil id
                let id = $('#id-edit').val()

                // hapus validasi
                var form = $('#form-edit-siswa')
                form.find('.form-text').remove()

                // animasi
                let btn = document.getElementById('btn-edi-siswa')
                btn.setAttribute('disabled', true)
                let loading = document.getElementById('loading-edit')
                loading.style.display = 'block'

                let formData = new FormData($('#form-edit-siswa')[0])

                $.ajax({
                    type: "POST",
                    url: "/siswa/update/" + id,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function() {

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Siswa berhasil diedit'
                        })

                        setTimeout(() => {
                            window.location.href = '/siswa'
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
