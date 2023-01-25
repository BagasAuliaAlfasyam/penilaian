@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Edit Guru</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('guru') }}">guru</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('guru/edit/' . $data['id']) }}">edit guru</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-5 bg-table">

                <form action="" id="form-edit-guru">
                    <input type="hidden" id="id" value="{{ $data['id'] }}">
                    <div class="form-group mb-3">
                        <label>NIP</label>
                        <input type="text" name="nip-edit" id="nip-edit" value="{{ $data['nip'] }}" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama-edit" id="nama-edit" class="form-control fc-edited" value="{{ $data['nama_guru'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="text" name="email-edit" id="email-edit" class="form-control fc-edited" value="{{ $data['email'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin-edit" id="jenis_kelamin-edit" class="form-control fc-edited">
                            <option value="L" {{ $data['jenis_kelamin'] == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $data['jenis_kelamin'] == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon-edit" id="telepon-edit" value="{{ $data['telepon'] }}" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat-edit" id="alamat-edit" rows="3" class="form-control fc-edited">{{ $data['alamat'] }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username-edit" id="username-edit" class="form-control fc-edited" value="{{ $data['username'] }}">
                    </div>
                    <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-guru">
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

            // edit guru
            $(document).on('submit', '#form-edit-guru', function(e) {
                e.preventDefault()

                let id = $('#id').val()

                // hapus validasi
                var form = $('#form-edit-guru')
                form.find('.form-text').remove()

                // animasi
                let btn = document.getElementById('btn-edi-guru')
                btn.setAttribute('disabled', true)
                let loading = document.getElementById('loading-edit')
                loading.style.display = 'block'

                let formData = new FormData($('#form-edit-guru')[0])

                $.ajax({
                    type: "POST",
                    url: "/guru/update/" + id,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function() {

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Guru berhasil diedit'
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
