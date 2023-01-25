@extends('layout/dashboard')

@section('konten')
    <input type="hidden" id="route_id" value="{{ $route_id }}">

    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Wali kelas - Siswa</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('wali_kelas') }}">wali kelas</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('wali_kelas/' . $route_id . '/siswa') }}">siswa</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <div class="float-end">
                            <a href="{{ url('wali_kelas') }}" class="btn btn-sm btn-dark me-1">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-siswa">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>Peringkat</th>
                                <th>Siswa</th>
                                <th>Kelakuan</th>
                                <th>Kerajinan</th>
                                <th>Kebersihan</th>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alpha</th>
                                <th>Catatan Wali Kelas</th>
                                <th>Total Nilai</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-siswa">

                        </tbody>
                    </table>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-edit"></button>
                </div>
                <div class="modal-body">

                    <div class="notifikasi-duplikat-edit"></div>

                    <form action="" id="form-edit">
                        <input type="hidden" name="id_wali_kelas_siswa" id="id_wali_kelas_siswa">

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Kelakuan</label>
                                    <select name="kelakuan" id="kelakuan" class="form-control fc-edited">
                                        <option value="">---</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Kerajinan</label>
                                    <select name="kerajinan" id="kerajinan" class="form-control fc-edited">
                                        <option value="">---</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Kebersihan</label>
                                    <select name="kebersihan" id="kebersihan" class="form-control fc-edited">
                                        <option value="">---</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Sakit</label>
                                    <input type="number" min="0" name="sakit" id="sakit" class="form-control fc-edited">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Izin</label>
                                    <input type="number" min="0" name="izin" id="izin" class="form-control fc-edited">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Alpha</label>
                                    <input type="number" min="0" name="alpha" id="alpha" class="form-control fc-edited">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Catatan Wali Kelas</label>
                                    <textarea rows="3" class="form-control fc-edited" name="catatan_wali_kelas" id="catatan_wali_kelas"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label>Jumlah Keseluruhan Nilai</label>
                                    <input type="number" name="nilai_akhir" id="nilai_akhir" class="form-control fc-edited" readonly>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edit">
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

    <!-- modal nilai -->
    <div class="modal fade" id="staticBackdropNilai" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Raport</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-raport"></button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid px-4">
                        <div class="row" style="padding:0 10px;">
                            <div class="col-12 col-md-12">
                                <div class="row">
                                    <table class="table table-sm" style="font-size:14px;border:1px solid transparent;" id="tab-siswa">
                                        <thead>
                                            <tr>
                                                <td>Nama Sekolah</td>
                                                <td>:</td>
                                                <td><b>SMA Negeri 7 Lhokseumawe</b></td>
                                                <td>Kelas</td>
                                                <td>:</td>
                                                <td><span id="td_kelas"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>:</td>
                                                <td>Jl. Rancung, Batuphat Timur,</td>
                                                <td>Semester</td>
                                                <td>:</td>
                                                <td><span id="td_semester"></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>Kec. Muara Satu, Kota Lhokseumawe</td>
                                                <td>Tahun Pelajaran</td>
                                                <td>:</td>
                                                <td><span id="td_tahun_pelajaran"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Murid</td>
                                                <td>:</td>
                                                <td><b><span id="td_nama_siswa"></span></b></td>
                                                <td>Nomor Induk</td>
                                                <td>:</td>
                                                <td><span id="td_nisn"></span></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row mb-4">
                                    <table class="table table-sm table-bordered" style="font-size:14px;">
                                        <tr style="text-align:center;">
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Mata Pelajaran</th>
                                            <th colspan="2">Nilai Prestasi</th>
                                            <th rowspan="2" style="width:10%;">Rata-rata Angka</th>
                                        </tr>
                                        <tr style="text-align:center;">
                                            <th style="width:10%;">Angka</th>
                                            <th>Huruf</th>
                                        </tr>

                                        <tbody id="td_mapel" style="border-top:1px">

                                        </tbody>

                                        <tbody style="border-top:1px">
                                            <tr>
                                                <td>
                                                    <div style="color:transparent;">-</div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tbody style="border-top:1px">
                                            <tr>
                                                <th colspan="2" style="text-align:center;width:40%;">Jumlah</th>
                                                <th style="text-align:center;" id="td_jumlah"></th>
                                                <th colspan="2" style="text-align:center;">
                                                    <i id="td_jumlah_terbilang">

                                                    </i>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align:center;">Rata-rata</th>

                                                <th style="text-align:center;" id="td_rata_rata"></th>

                                                <th style="text-align:center;" colspan="2">
                                                    <i id="td_rata_rata_terbilang"></i>
                                                </th>

                                            </tr>
                                            <tr>
                                                <td colspan="2">Peringkat kelas ke :</td>
                                                <td style="text-align:center;border-left:1px solid transparent;"><b id="td_peringkat"></b></td>
                                                <td colspan="2">
                                                    <div style="display:flex;justify-content:space-evenly;width:100%;">
                                                        <div>Dari</div>
                                                        <div id="td_jumlah_siswa"></div>
                                                        <div>Murid</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mb-4">
                                    <table class="table table-sm table-bordered" style="font-size:14px;">
                                        <tr>
                                            <td></td>
                                            <td style="width:30%;"></td>
                                            <td style="text-align:center;">Nilai</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="4" style="width:40%;">Kepribadian</td>
                                        </tr>
                                        <tr>
                                            <td>1. Kelakuan</td>
                                            <td style="text-align:center;" id="td_kelakuan">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Kerajinan</td>
                                            <td style="text-align:center;" id="td_kerajinan">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. Kebersihan</td>
                                            <td style="text-align:center;" id="td_kebersihan">

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row mb-4">
                                    <table class="table table-sm table-bordered" style="font-size:14px;">
                                        <tr>
                                            <td rowspan="4" style="width:40%;">Ketidakhadiran</td>
                                        </tr>
                                        <tr>
                                            <td style="width:30%;">1. Sakit</td>
                                            <td style="text-align:center;" id="td_sakit"></td>
                                        </tr>
                                        <tr>
                                            <td>2. Izin</td>
                                            <td style="text-align:center;" id="td_izin"></td>
                                        </tr>
                                        <tr>
                                            <td>3. Alpha</td>
                                            <td style="text-align:center;" id="td_alpha"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><b><i>Catatan Wali Siswa : <span id="td_catatan_wali_kelas"></span></i></b></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row mb-4">
                                    <table class="table table-sm table-bordered" style="font-size:14px;border:1px solid transparent;">
                                        <tr>
                                            <td style="width:33%;"></td>
                                            <td style="width:33%;"></td>
                                            <td style="width:34%;">Lhokseumawe, <span id="td_tanggal"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Mengetahui,</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Orang Tua / Wali</td>
                                            <td>Wali Kelas</td>
                                            <td>Kepala Sekolah</td>
                                        </tr>
                                        <tr style="height:100px;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><b><u id="td_wali_siswa"></u></b></td>
                                            <td><b><u id="td_wali_kelas"></u></b></td>
                                            <td><b><u>Ust. H. Ahmad Ghozali</u></b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {

            var route_id = $('#route_id').val()

            // ambil data
            ambilData()

            function ambilData() {
                let baris = 0
                $.ajax({
                    type: "GET",
                    url: "/wali_kelas/" + route_id + "/ambil_data",
                    success: function(response) {
                        $('.tbody-siswa').html('')
                        $.each(response.data, function(key, value) {
                            baris = baris + 1

                            // kondisi kelakuan
                            if (value.kelakuan == null) {
                                var kel = '-'
                            } else {
                                var kel = value.kelakuan
                            }

                            // kondisi kerajinan
                            if (value.kerajinan == null) {
                                var ker = '-'
                            } else {
                                var ker = value.kerajinan
                            }

                            // kondisi kebersihan
                            if (value.kebersihan == null) {
                                var keb = '-'
                            } else {
                                var keb = value.kebersihan
                            }

                            // kondisi catatan wali kelas
                            if (value.catatan_wali_kelas == null) {
                                var cat_wal = '-'
                            } else {
                                var cat_wal = value.catatan_wali_kelas
                            }

                            // kondisi status
                            if (value.jumlah_nilai != value.nilai_akhir) {
                                if (value.jumlah_nilai == 0) {
                                    var status = '<span class="badge rounded-pill bg-danger">Belum update</span>'
                                } else {
                                    var status = '<span class="badge rounded-pill bg-warning">Ada perubahan</span>'
                                }
                                var nilai = ''
                                var print = ''
                            } else {
                                var status = '<span class="badge rounded-pill bg-primary">Updated</span>'
                                var nilai =
                                    '<button data-bs-toggle="modal" data-bs-target="#staticBackdropNilai" class="btn btn-sm btn-info nilai_raport" wali_kelas_id="' +
                                    value.wali_kelas_id + '" wali_kelas_siswa="' + value.id + '" siswa_client="' + value
                                    .siswa_id + '" tp="' + value.tahun_pelajaran + '" sm="' + value.semester +
                                    '" peringkat="' + baris + '">Nilai</button>'
                                var print = '<a target="blank" href="/wali_kelas/' + value.wali_kelas_id +
                                    '/wali_kelas_siswa/' + value.id + '/siswa_client/' + value.siswa_id + '/tp/' + value
                                    .tahun_pelajaran + '/sm/' + value.semester + '/peringkat/' + baris +
                                    '/print" class="btn btn-sm" style="background-color:brown;color:white;">Print</a>'
                            }

                            $('.tbody-siswa').append('<tr>\
                                                    <td>' + baris + '</td>\
                                                    <td>' + value.nama_siswa + '</td>\
                                                    <td>' + kel + '</td>\
                                                    <td>' + ker + '</td>\
                                                    <td>' + keb + '</td>\
                                                    <td>' + value.sakit + '</td>\
                                                    <td>' + value.izin + '</td>\
                                                    <td>' + value.alpha + '</td>\
                                                    <td>' + cat_wal + '</td>\
                                                    <td>' + value.jumlah_nilai + '</td>\
                                                    <td>' + status +
                                '</td>\
                                                    <td>\
                                                        <button class="btn btn-sm btn-success btn-edit" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit" wali_kelas_siswa_id="' +
                                value.id + '" wali_kelas_id="' + value.wali_kelas_id + '" siswa_id="' + value.siswa_id +
                                '" tahun_pelajaran="' + value.tahun_pelajaran + '" semester="' + value.semester + '">Edit</button>\
                                                        ' + nilai + '\
                                                        ' + print + '\
                                                    </td>\
                                                </tr>')
                        })
                        $('#tab-siswa').DataTable({
                            language: {
                                url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
                            },
                        })
                    }
                })
            }

            // ambil detail mapel untuk modal edit
            $(document).on('click', '.btn-edit', function() {

                var wali_kelas_siswa_id = $(this).attr('wali_kelas_siswa_id')
                var wali_kelas_id = $(this).attr('wali_kelas_id')
                var siswa_id = $(this).attr('siswa_id')
                var tahun_pelajaran = $(this).attr('tahun_pelajaran')
                var semester = $(this).attr('semester')
                // var kelas = $(this).attr('kelas')

                $.ajax({
                    type: 'GET',
                    url: '/wali_kelas/' + wali_kelas_id +
                        '/wali_kelas_siswa/' + wali_kelas_siswa_id + '/siswa_client/' + siswa_id + '/tp/' + tahun_pelajaran +
                        '/sm/' + semester + '/data_edit',
                    success: function(response) {
                        $('#id_wali_kelas_siswa').val(response.data.id)

                        $('#kelakuan').val(response.data.kelakuan)
                        $('#kerajinan').val(response.data.kerajinan)
                        $('#kebersihan').val(response.data.kebersihan)
                        $('#sakit').val(response.data.sakit)
                        $('#izin').val(response.data.izin)
                        $('#alpha').val(response.data.alpha)
                        $('#catatan_wali_kelas').val(response.data.catatan_wali_kelas)
                        $('#nilai_akhir').val(response.nilai_akhir)
                    }
                })
            })

            // ajax toke setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // edit 
            $(document).on('submit', '#form-edit', function(e) {
                e.preventDefault()

                // ambil id
                let id = $('#id_wali_kelas_siswa').val()

                // animasi
                let btn = document.getElementById('btn-edit')
                btn.setAttribute('disabled', true)
                let loading = document.getElementById('loading-edit')
                loading.style.display = 'block'

                let formData = new FormData($('#form-edit')[0])

                $.ajax({
                    type: "POST",
                    url: "/wali_kelas_siswa_admin/" + id,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function() {
                        $('#tab-siswa').DataTable().destroy()
                        ambilData()

                        $('#btn-close-modal-edit').click()

                        // hilangkan animasi
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)

                        // notifikasi
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil diedit'
                        })
                    },
                    error: function() {
                        toastFail.fire({
                            icon: 'error',
                            title: 'INTERNAL SERVER ERROR'
                        })
                    }
                })
            })

            // modal nilai
            $(document).on('click', '.nilai_raport', function() {

                var wali_kelas_id = $(this).attr('wali_kelas_id')
                var wali_kelas_siswa = $(this).attr('wali_kelas_siswa')
                var siswa_client = $(this).attr('siswa_client')
                var tp = $(this).attr('tp')
                var sm = $(this).attr('sm')
                var peringkat = $(this).attr('peringkat')

                var no = 0

                $.ajax({
                    type: 'GET',
                    url: '/wali_kelas/' + wali_kelas_id +
                        '/wali_kelas_siswa/' + wali_kelas_siswa + '/siswa_client/' + siswa_client + '/tp/' + tp + '/sm/' +
                        sm + '/peringkat/' + peringkat,
                    success: function(response) {

                        $('#td_kelas').append(response.siswa.kelas)
                        $('#td_semester').append(response.tahun_pelajaran.semester)
                        $('#td_tahun_pelajaran').append(response.tahun_pelajaran.tahun_pelajaran)
                        $('#td_nama_siswa').append(response.siswa.nama_siswa)
                        $('#td_nisn').append(response.siswa.nisn)

                        $('#td_mapel').html('')
                        $.each(response.nilai, function(key, value) {
                            no = no + 1

                            $('#td_mapel').append('<tr>\
                                                <td style="text-align:center;">' + no + '</td>\
                                                <td>' + value.mata_pelajaran + '</td>\
                                                <td style="text-align:center;">' + value.nilai_akhir + '</td>\
                                                <td style="text-align:center;"><i>' + value.nilai_akhir_terbilang + '</i></td>\
                                                <td style="text-align:center;">' + value.rata_rata_nilai + '</td>\
                                            </tr>')
                        })

                        $('#td_jumlah').append(response.jumlah)
                        $('#td_jumlah_terbilang').append(response.jumlah_terbilang)
                        $('#td_rata_rata').append(response.rata_rata)
                        $('#td_rata_rata_terbilang').append(response.rata_rata_terbilang)
                        $('#td_peringkat').append(response.peringkat)
                        $('#td_jumlah_siswa').append(response.jumlah_siswa)

                        if (response.wali_kelas_siswa.kelakuan != null) {
                            $('#td_kelakuan').append(response.wali_kelas_siswa.kelakuan)
                        } else {
                            $('#td_kelakuan').append('-')
                        }
                        if (response.wali_kelas_siswa.kerajinan != null) {
                            $('#td_kerajinan').append(response.wali_kelas_siswa.kerajinan)
                        } else {
                            $('#td_kerajinan').append('-')
                        }
                        if (response.wali_kelas_siswa.kebersihan != null) {
                            $('#td_kebersihan').append(response.wali_kelas_siswa.kebersihan)
                        } else {
                            $('#td_kebersihan').append('-')
                        }
                        $('#td_sakit').append(response.wali_kelas_siswa.sakit)
                        $('#td_izin').append(response.wali_kelas_siswa.izin)
                        $('#td_alpha').append(response.wali_kelas_siswa.alpha)
                        $('#td_catatan_wali_kelas').append(response.wali_kelas_siswa.catatan_wali_kelas)

                        $('#td_tanggal').append(response.tanggal)

                        $('#td_wali_siswa').append(response.siswa.wali)
                        $('#td_wali_kelas').append(response.wali_kelas)
                    }
                })
            })

            // tutup modal raport
            $(document).on('click', '#btn-close-modal-raport', function() {
                $('#td_kelas').html('')
                $('#td_semester').html('')
                $('#td_tahun_pelajaran').html('')
                $('#td_nama_siswa').html('')
                $('#td_nisn').html('')

                $('#td_jumlah').html('')
                $('#td_jumlah_terbilang').html('')
                $('#td_rata_rata').html('')
                $('#td_rata_rata_terbilang').html('')
                $('#td_peringkat').html('')
                $('#td_jumlah_siswa').html('')

                $('#td_kelakuan').html('')
                $('#td_kerajinan').html('')
                $('#td_kebersihan').html('')
                $('#td_sakit').html('')
                $('#td_izin').html('')
                $('#td_alpha').html('')
                $('#td_catatan_wali_kelas').html('')

                $('#td_tanggal').html('')

                $('#td_wali_siswa').html('')
                $('#td_wali_kelas').html('')
            })
        })
    </script>
@endpush
