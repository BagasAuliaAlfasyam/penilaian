@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Wali Kelas</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('wali_kelas') }}">wali kelas</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah</button>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-wali-kelas">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>No</th>
                                <th>Guru</th>
                                <th>Tahun Pelajaran</th>
                                <th>Semester</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tambah -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-tambah"></button>
                </div>
                <div class="modal-body">

                    <div class="notifikasi-duplikat"></div>

                    <form action="" id="form-tambah-wali-kelas">
                        <div class="form-group mb-3">
                            <label>Guru</label>
                            <select name="guru" id="guru" class="form-control fc-edited">
                                <option value="">----</option>
                                @foreach ($guru as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Tahun Pelajaran</label>
                            <select name="tahun_pelajaran" id="tahun_pelajaran" class="form-control fc-edited">
                                <option value="">----</option>
                                @foreach ($tahun_pelajaran as $tp)
                                    <option value="{{ $tp->tahun_pelajaran }}">{{ $tp->tahun_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Semester</label>
                            <select name="semester" id="semester" class="form-control fc-edited">
                                <option value="">----</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kelas</label>
                            <select name="kelas" id="kelas" class="form-control fc-edited">
                                <option value="">----</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-tam-wali-kelas">
                            <div>Tambah</div>
                            <svg id="loading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px"
                                height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
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
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="staticBackdropEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-edit"></button>
                </div>
                <div class="modal-body">

                    <div class="notifikasi-duplikat-edit"></div>

                    <form action="" id="form-edit-wali-kelas">
                        <input type="hidden" name="id_edit" id="id_edit">
                        <input type="hidden" name="id_guru" id="id_guru">

                        <div class="form-group mb-3">
                            <label>Guru</label>
                            <select name="guru_edit" id="guru_edit" class="form-control fc-edited">
                                @foreach ($guru as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-wali-kelas">
                            <div>Edit</div>
                            <svg id="loading-edit" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px"
                                height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                <g>
                                    <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff"
                                        stroke-width="12"></path>
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
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script>
        // ambil data tahun pelajaran
        $('#tab-wali-kelas').DataTable({
            language: {
                url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
            },
            serverSide: true,
            responsive: true,
            ajax: {
                url: 'wali_kelas',
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'guru',
                    name: 'guru'
                },
                {
                    data: 'tahun_pelajaran',
                    name: 'tahun_pelajaran'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        })

        // ajax toke setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // hapus validasi saat tutup modal tambah
        function tutup_modal() {
            var form = $('#form-tambah-wali-kelas')
            form.find('.form-text').remove()
            $('#guru').val('')
            $('#tahun_pelajaran').val('')
            $('#semester').val('')
            $('#kelas').val('')
            $('.notifikasi-duplikat').html('')
        }

        $(document).on('click', '#btn-close-modal-tambah', function() {
            tutup_modal()
        })

        // tambah mata pelajaran
        $(document).on('submit', '#form-tambah-wali-kelas', function(e) {
            e.preventDefault()

            // hapus validasi
            var form = $('#form-tambah-wali-kelas')
            form.find('.form-text').remove()

            // hapus duplikat notifikasi
            $('.notifikasi-duplikat').html('')

            // animasi
            let btn = document.getElementById('btn-tam-wali-kelas')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading')
            loading.style.display = 'block'

            let formData = new FormData($('#form-tambah-wali-kelas')[0])

            $.ajax({
                type: "POST",
                url: "/wali_kelas/tambah",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.duplikat) {
                        $('.notifikasi-duplikat').append('<div class="alert alert-danger">' + response.duplikat + '</div>')
                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)
                    } else {
                        $('#tab-wali-kelas').DataTable().ajax.reload()
                        $('#btn-close-modal-tambah').click()

                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Wali kelas berhasil ditambahkan'
                        })
                    }
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

        // hapus validasi saat tutup modal edit
        function tutup_modal_edit() {
            var form = $('#form-edit-wali-kelas')
            form.find('.form-text').remove()
            $('#id_edit').val('')
            $('#guru_edit').val('')
            $('.notifikasi-duplikat-edit').html('')
        }

        $(document).on('click', '#btn-close-modal-edit', function() {
            tutup_modal_edit()
        })

        // ambil data untuk modal edit wali kelas
        $(document).on('click', '.edit-wali-kelas', function() {
            var id = $(this).attr('id')

            $.ajax({
                type: "GET",
                url: "/wali_kelas/" + id,
                success: function(response) {
                    $('#id_edit').val(response.data.id)
                    $('#id_guru').val(response.data.guru_id)
                    $('#guru_edit').val(response.data.guru_id)
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })

        // edit wali kelas
        $(document).on('submit', '#form-edit-wali-kelas', function(e) {
            e.preventDefault()

            var id = $('#id_edit').val()

            // hapus validasi
            var form = $('#form-edit-wali-kelas')
            form.find('.form-text').remove()

            // hapus duplikat notifikasi
            $('.notifikasi-duplikat-edit').html('')

            // animasi
            let btn = document.getElementById('btn-edi-wali-kelas')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading-edit')
            loading.style.display = 'block'

            let formData = new FormData($('#form-edit-wali-kelas')[0])

            $.ajax({
                type: "POST",
                url: "/wali_kelas/edit/" + id,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.duplikat) {
                        $('.notifikasi-duplikat-edit').append('<div class="alert alert-danger">' + response.duplikat + '</div>')
                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)
                    } else {
                        $('#tab-wali-kelas').DataTable().ajax.reload()
                        $('#btn-close-modal-edit').click()

                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Wali kelas berhasil diedit'
                        })
                    }
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

        // aktifkan sebagai wali kelas
        $(document).on('click', '.aktifkan', function(e) {
            e.preventDefault()
            let id = $(this).attr('id')
            let id_guru = $(this).attr('id_guru')

            Swal.fire({
                title: 'Apa kamu yakin ?',
                text: "ingin mengaktifkan wali kelas ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, aktifkan',
                cancelButtonText: 'Kembali',
                cancelButtonColor: 'black'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "/wali_kelas/aktifkan/" + id + "/" + id_guru,
                        success: function(response) {
                            if (response.duplikat) {

                                toastFail.fire({
                                    icon: 'error',
                                    title: response.duplikat
                                })
                            } else {
                                $('#tab-wali-kelas').DataTable().ajax.reload()

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Wali kelas berhasil diaktifkan'
                                })
                            }
                        },
                        error: function() {
                            toastFail.fire({
                                icon: 'error',
                                title: 'INTERNAL SERVER ERROR'
                            })
                        }
                    })

                }
            })
        })

        // non aktifkan wali kelas
        $(document).on('click', '.non-aktifkan', function(e) {
            e.preventDefault()
            let id = $(this).attr('id')

            Swal.fire({
                title: 'Apa kamu yakin ?',
                text: "ingin menonaktifkan wali kelas ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Non aktifkan',
                cancelButtonText: 'Kembali',
                cancelButtonColor: 'black'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "/wali_kelas/nonaktifkan/" + id,
                        success: function(response) {
                            $('#tab-wali-kelas').DataTable().ajax.reload()

                            Toast.fire({
                                icon: 'success',
                                title: 'Wali kelas berhasil di non-aktifkan'
                            })
                        },
                        error: function() {
                            toastFail.fire({
                                icon: 'error',
                                title: 'INTERNAL SERVER ERROR'
                            })
                        }
                    })

                }
            })
        })
    </script>
@endpush
