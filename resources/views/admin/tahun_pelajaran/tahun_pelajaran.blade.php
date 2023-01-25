@extends('layout/dashboard')

@section('konten')
<div class="container-fluid px-4">
    <div class="content-top">
        <h1 style="font-size:20px;">Tahun Pelajaran</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ url('tahun_pelajaran') }}">tahun pelajaran</a></li>
        </ol>
    </div>
    <div class="row" style="padding:0 10px;">
        <div class="col-12 col-md-12 bg-table">
            <div class="row mb-3">
                <div class="col">
                    <a href="#" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah</a>
                </div>
            </div>
            <div class="row">
                <table class="table" style="font-size:14px;" id="tab-thn-pelajaran">
                    <thead>
                        <tr style="border-bottom:2px solid #5034FF;">
                            <th>No</th>
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Tahun Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-tambah"></button>
      </div>
      <div class="modal-body">

        <div class="notifikasi-duplikat"></div>

        <form action="" id="form-tambah-tahun-pelajaran">
            <div class="form-group mb-3">
                <label>Tahun Pelajaran</label>
                <input type="text" name="tahun_pelajaran" id="tahun_pelajaran" class="form-control fc-edited">
            </div>
            <div class="form-group mb-3">
                <label>Semester</label>
                <select name="semester" id="semester" class="form-control fc-edited">
                    <option value="">----</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>
            <button class="btn btn-sm btn-primary float-end d-flex" id="btn-tam-thn-pelajaran">
                <div>Tambah</div>
                <svg id="loading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <g>
                    <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                    <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </g>
                </svg>
            </button>
        </form>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="staticBackdropEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Tahun Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal-edit"></button>
      </div>
      <div class="modal-body">

        <div class="notifikasi-duplikat-edit"></div>

        <form action="" id="form-edit-tahun-pelajaran">
            <input type="hidden" id="id_edit">
            <input type="hidden" id="tahun_pelajaran_old" name="tahun_pelajaran_old">
            <input type="hidden" id="semester_old" name="semester_old">
            <div class="form-group mb-3">
                <label>Tahun Pelajaran</label>
                <input type="text" name="tahun_pelajaran_edit" id="tahun_pelajaran_edit" class="form-control fc-edited">
            </div>
            <div class="form-group mb-3">
                <label>Semester</label>
                <select name="semester_edit" id="semester_edit" class="form-control fc-edited">
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>
            <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-thn-pelajaran">
                <div>Edit</div>
                <svg id="loading-edit" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <g>
                    <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                    <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
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
    $('#tab-thn-pelajaran').DataTable({
        language: {
            url: '{{ asset("plugins/datatable-bahasa/bahasa-indonesia.json") }}'
        },
        serverSide: true,
        responsive: true,
        ajax: {
            url: 'tahun_pelajaran',
        },
        columns: [
            {
            "data" : null, "sortable" : false,
            render: function(data, type, row, meta){
                return meta.row + meta.settings._iDisplayStart + 1
            }
            },
            {data: 'tahun_pelajaran', name: 'tahun_pelajaran'},
            {data: 'semester', name: 'semester'},
            {data: 'action', name: 'action'}
        ]
    })

    // ajax toke setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // hapus validasi saat tutup modal tambah
    function tutup_modal(){
        var form = $('#form-tambah-tahun-pelajaran')
        form.find('.form-text').remove()
        $('#tahun_pelajaran').val('')
        $('#semester').val('')
        $('.notifikasi-duplikat').html('')
    }

    $(document).on('click', '#btn-close-modal-tambah', function(){
        tutup_modal()
    })

    // hapus validasi saat tutup modal edit
    function tutup_modal_edit(){
        var form = $('#form-edit-tahun-pelajaran')
        form.find('.form-text').remove()
        $('#tahun_pelajaran_edit').val('')
        $('#semester_edit').val('')
        $('.notifikasi-duplikat-edit').html('')
    }

    $(document).on('click', '#btn-close-modal-edit', function(){
        tutup_modal_edit()
    })

    // tambah mata pelajaran
    $(document).on('submit', '#form-tambah-tahun-pelajaran', function(e){
        e.preventDefault()

        // hapus validasi
        var form = $('#form-tambah-tahun-pelajaran')
        form.find('.form-text').remove()

        // hapus duplikat notifikasi
        $('.notifikasi-duplikat').html('')

        // animasi
        let btn = document.getElementById('btn-tam-thn-pelajaran')
        btn.setAttribute('disabled', true)
        let loading = document.getElementById('loading')
        loading.style.display = 'block'

        let formData = new FormData($('#form-tambah-tahun-pelajaran')[0])

        $.ajax({
            type: "POST",
            url: "/tahun_pelajaran/tambah",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.duplikat){
                    $('.notifikasi-duplikat').append('<div class="alert alert-danger">'+response.duplikat+'</div>')
                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)
                }else{
                    $('#tab-thn-pelajaran').DataTable().ajax.reload()
                    $('#btn-close-modal-tambah').click()
    
                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)
    
                    // notifikasi
                    Toast.fire({
                        icon: 'success',
                        title: 'Tahun pelajaran berhasil ditambahkan'
                    })
                }
            },
            error: function(xhr){
                var res = xhr.responseJSON;
                if($.isEmptyObject(res) == false){
                    $.each(res.errors, function(key, value){
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
    $(document).on('click', '.modal-edit', function(){
        var id = $(this).attr('id')

        $.ajax({
            type: "GET",
            url: "/tahun_pelajaran/edit/"+id,
            success: function(response){
                $('#id_edit').val(response.data.id)
                $('#tahun_pelajaran_edit').val(response.data.tahun_pelajaran)
                $('#semester_edit').val(response.data.semester)

                $('#semester_old').val(response.data.semester)
                $('#tahun_pelajaran_old').val(response.data.tahun_pelajaran)
            },
            error: function(error){
                console.log(error)
            }
        })
    })

    // edit tahun pelajaran
    $(document).on('submit', '#form-edit-tahun-pelajaran', function(e){
        e.preventDefault()

        var id = $('#id_edit').val()

        // hapus validasi
        var form = $('#form-edit-tahun-pelajaran')
        form.find('.form-text').remove()

        // hapus duplikat notifikasi
        $('.notifikasi-duplikat-edit').html('')

        // animasi
        let btn = document.getElementById('btn-edi-thn-pelajaran')
        btn.setAttribute('disabled', true)
        let loading = document.getElementById('loading-edit')
        loading.style.display = 'block'

        let formData = new FormData($('#form-edit-tahun-pelajaran')[0])

        $.ajax({
            type: "POST",
            url: "/tahun_pelajaran/update/"+id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.duplikat){
                    $('.notifikasi-duplikat-edit').append('<div class="alert alert-danger">'+response.duplikat+'</div>')
                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)
                }else{
                    $('#tab-thn-pelajaran').DataTable().ajax.reload()
                    $('#btn-close-modal-edit').click()
    
                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)
    
                    // notifikasi
                    Toast.fire({
                        icon: 'success',
                        title: 'Tahun pelajaran berhasil diedit'
                    })
                }
            },
            error: function(xhr){
                var res = xhr.responseJSON;
                if($.isEmptyObject(res) == false){
                    $.each(res.errors, function(key, value){
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

</script>
@endpush