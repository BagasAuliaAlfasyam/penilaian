@extends('layout/dashboard')

@section('konten')
    <input type="hidden" id="id-mapel-guru" value="{{ $data->id }}">
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Daftar Mapel dan guru tahun pelajaran <b>{{ $data->tahun_pelajaran }}</b> semester <b>{{ $data->semester }}</b>
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('tahun_pelajaran') }}">tahun pelajaran</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('tahun_pelajaran/' . $data->id . '/mapel_guru') }}">mapel guru</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <div class="float-end">
                            <a href="{{ url('tahun_pelajaran') }}" class="btn btn-sm btn-dark me-1">Kembali</a>
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-mapel-guru">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>No</th>
                                <th>Guru</th>
                                <th>Mata Pelajaran</th>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah guru dan mapel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-tambah"></button>
                </div>
                <div class="modal-body">

                    <div class="notifikasi-duplikat"></div>

                    <form action="" id="form-tambah-mapel-guru">
                        <input type="hidden" name="tahun_pelajaran_id" id="tahun_pelajaran_id" value="{{ $data->id }}">
                        <div class="form-group mb-3">
                            <label>Guru</label>
                            <select name="guru" id="guru" class="form-control fc-edited">
                                <option value="">----</option>
                                @foreach ($guru as $us)
                                    <option value="{{ $us->id }}">{{ $us->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Mata pelajaran</label>
                            <select name="mapel" id="mapel" class="form-control fc-edited">
                                <option value="">----</option>
                                @foreach ($mapel as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_mata_pelajaran }}</option>
                                @endforeach
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
                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-tam-ust-map">
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
                    <h5 class="modal-title" id="staticBackdropLabel">Edit guru dan mapel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-edit"></button>
                </div>
                <div class="modal-body">

                    <div class="notifikasi-duplikat-edit"></div>

                    <form action="" id="form-edit-mapel-guru">
                        <input type="hidden" id="id_mapel_guru_edit">
                        <input type="hidden" name="id_thn_pel_edit" id="id_thn_pel_edit">
                        <input type="hidden" name="guru-edit-old" id="guru-edit-old">
                        <input type="hidden" name="mapel-edit-old" id="mapel-edit-old">
                        <input type="hidden" name="kelas-edit-old" id="kelas-edit-old">
                        <div class="form-group mb-3">
                            <label>Guru</label>
                            <select name="guru-edit" id="guru-edit" class="form-control fc-edited">
                                @foreach ($guru as $us)
                                    <option value="{{ $us->id }}">{{ $us->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Mata pelajaran</label>
                            <select name="mapel-edit" id="mapel-edit" class="form-control fc-edited">
                                @foreach ($mapel as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_mata_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Kelas</label>
                            <input type="text" name="kelas-edit" id="kelas-edit" class="form-control fc-edited" readonly>
                        </div>
                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-mapel-guru">
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
        // ambil data siswa
        var id_mapel_guru = $('#id-mapel-guru').val()
        $('#tab-mapel-guru').DataTable({
            language: {
                url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
            },
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/tahun_pelajaran/' + id_mapel_guru + '/mapel_guru',
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
                    data: 'mapel',
                    name: 'mapel'
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
            var form = $('#form-tambah-mapel-guru')
            form.find('.form-text').remove()
            $('.notifikasi-duplikat').html('')
            $('#guru').val('')
            $('#mapel').val('')
            $('#kelas').val('')
        }

        $(document).on('click', '#btn-close-modal-tambah', function() {
            tutup_modal()
        })

        // tambah mapel guru
        $(document).on('submit', '#form-tambah-mapel-guru', function(e) {
            e.preventDefault()

            // id tahun pelajaran
            var id_thn_pelajaran = $('#tahun_pelajaran_id').val()

            // // hapus validasi
            var form = $('#form-tambah-mapel-guru')
            form.find('.form-text').remove()

            // // hapus duplikat notifikasi
            $('.notifikasi-duplikat').html('')

            // animasi
            let btn = document.getElementById('btn-tam-ust-map')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading')
            loading.style.display = 'block'

            let formData = new FormData($('#form-tambah-mapel-guru')[0])

            $.ajax({
                type: "POST",
                url: "/tahun_pelajaran/" + id_thn_pelajaran + "/mapel_guru/tambah",
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
                        $('#tab-mapel-guru').DataTable().ajax.reload()
                        $('#btn-close-modal-tambah').click()

                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Mapel dan guru berhasil ditambahkan'
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

        // ambil data untuk modal edit
        $(document).on('click', '.edit-mapel-guru', function() {
            var id = $(this).attr('id')
            var thn_pel_id = $(this).attr('thn_pel_id')

            $.ajax({
                type: "GET",
                url: "/tahun_pelajaran/" + thn_pel_id + '/mapel_guru/' + id + '/edit',
                success: function(response) {
                    $('#id_mapel_guru_edit').val(response.data.id)
                    $('#id_thn_pel_edit').val(response.data.tahun_pelajaran_id)
                    $('#guru-edit').val(response.data.guru_id)
                    $('#mapel-edit').val(response.data.mapel_id)
                    $('#kelas-edit').val(response.data.kelas)

                    $('#guru-edit-old').val(response.data.guru_id)
                    $('#mapel-edit-old').val(response.data.mapel_id)
                    $('#kelas-edit-old').val(response.data.kelas)
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })

        // hapus validasi saat tutup modal edit
        function tutup_modal_edit() {
            var form = $('#form-edit-mapel-guru')
            form.find('.form-text').remove()
            $('.notifikasi-duplikat-edit').html('')
        }

        $(document).on('click', '#btn-close-modal-edit', function() {
            tutup_modal_edit()
        })

        // edit mapel guru
        $(document).on('submit', '#form-edit-mapel-guru', function(e) {
            e.preventDefault()

            // id tahun pelajaran
            var id_mapel_guru = $('#id_mapel_guru_edit').val()
            var id_thn_pelajaran = $('#id_thn_pel_edit').val()

            // // hapus validasi
            var form = $('#form-edit-mapel-guru')
            form.find('.form-text').remove()

            // // hapus duplikat notifikasi
            $('.notifikasi-duplikat-edit').html('')

            // animasi
            let btn = document.getElementById('btn-edi-mapel-guru')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading-edit')
            loading.style.display = 'block'

            let formData = new FormData($('#form-edit-mapel-guru')[0])

            $.ajax({
                type: "POST",
                url: "/tahun_pelajaran/" + id_thn_pelajaran + "/mapel_guru/" + id_mapel_guru + "/update",
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
                        $('#tab-mapel-guru').DataTable().ajax.reload()
                        $('#btn-close-modal-edit').click()

                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Mapel dan guru berhasil diedit'
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

        // publish mapel guru
        $(document).on('click', '.publish-mapel-guru', function(e) {
            e.preventDefault()
            let id_mapel_guru = $(this).attr('id_mapel_guru')
            let id_thn_pelajaran = $(this).attr('id_thn_pelajaran')

            Swal.fire({
                title: 'Lanjutkan !',
                text: "jika sudah di publish maka tidak bisa dihapus lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, publish',
                cancelButtonText: 'Kembali',
                cancelButtonColor: 'black'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "/tahun_pelajaran/" + id_thn_pelajaran + "/mapel_guru/" + id_mapel_guru + "/publish",
                        success: function() {
                            $('#tab-mapel-guru').DataTable().ajax.reload()
                            Toast.fire({
                                icon: 'success',
                                title: 'Mapel dan guru berhasil dipublish'
                            })
                        }
                    })

                }
            })
        })

        // hapus mapel guru
        $(document).on('click', '.hapus-mapel-guru', function(e) {
            e.preventDefault()
            let id_mapel_guru = $(this).attr('id_mapel_guru')
            let id_thn_pelajaran = $(this).attr('id_thn_pelajaran')

            Swal.fire({
                title: 'Apa kamu yakin ?',
                text: "ingin menghapus Mapel dan guru ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Kembali',
                cancelButtonColor: 'black'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "DELETE",
                        url: "/tahun_pelajaran/" + id_thn_pelajaran + "/mapel_guru/" + id_mapel_guru + "/hapus",
                        success: function() {
                            $('#tab-mapel-guru').DataTable().ajax.reload()
                            Toast.fire({
                                icon: 'success',
                                title: 'Mapel dan guru berhasil dihapus'
                            })
                        }
                    })

                }
            })
        })
    </script>
@endpush
