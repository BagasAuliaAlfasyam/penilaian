@extends('layout/dashboard')

@section('konten') 
<div class="container-fluid px-4">
    <div class="content-top">
        <h1 style="font-size:20px;">Mata Pelajaran</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ url('mata_pelajaran') }}">mata pelajaran</a></li>
        </ol>
    </div>
    <div class="row" style="padding:0 10px;">
        <div class="col-12 col-md-8 mb-3 p-0">
            <div class="bg-table">
                <table class="table" id="example" style="font-size:14px;">
                    <thead>
                        <tr style="border-bottom:2px solid #5034FF;">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-md-4 mapel-form">
            <div class="bg-table" style="height:auto;">
                <form action="" id="form-tambah-mapel" style="padding-bottom:25px;">
                    <div class="form-group mb-3">
                        <label>Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control fc-edited">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mata_pelajaran" id="nama_mata_pelajaran" class="form-control fc-edited">
                    </div>
                    <button class="btn btn-sm btn-primary float-end d-flex" id="btn-tam-mapel">
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

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Mata Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal"></button>
      </div>
      <div class="modal-body">

        <form action="" id="form-edit-mapel">
            <input type="hidden" id="id">
            <div class="form-group mb-3">
                <label>Kode</label>
                <input type="text" name="kode_edit" id="kode_edit" class="form-control fc-edited">
            </div>
            <div class="form-group mb-3">
                <label>Nama Mata Pelajaran</label>
                <input type="text" name="nama_mata_pelajaran_edit" id="nama_mata_pelajaran_edit" class="form-control fc-edited">
            </div>

            <div>
                <div id="wait" style="display:none;float:left;">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;float:left;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                     <g>
                     <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#007bff" stroke-width="12"></path>
                     <path d="M49 3L49 27L61 15L49 3" fill="#007bff"></path>
                     <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                     </g>
                  </svg><span style="font-weight:bold;display:block;float:right;">Loading...</span>
               </div>
               <button class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-mapel">
                   <div>Edit</div>
                   <svg id="loading-edit" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                   <g>
                       <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                       <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                       <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                   </g>
                   </svg>
               </button>
            </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){

        // ambil data
        ambilData()
        function ambilData(){
            let baris = 0
            $.ajax({
                type: "GET",
                url: "mata_pelajaran/ambilData",
                success: function(response){
                $('tbody').html('')
                    $.each(response.mapel, function(key, value){
                        baris = baris + 1
                        $('tbody').append('<tr>\
                                            <td>'+baris+'</td>\
                                            <td>'+value.kode+'</td>\
                                            <td>'+value.nama_mata_pelajaran+'</td>\
                                            <td>\
                                                <button class="btn btn-sm btn-success btn-edi-mapel" id="'+value.id+'" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button>\
                                                <button class="btn btn-sm btn-danger btn-hap-mapel" id="'+value.id+'">Hapus</button>\
                                            </td>\
                                        </tr>')
                    })
                    $('#example').DataTable({
                        language: {
                            url: '{{ asset("plugins/datatable-bahasa/bahasa-indonesia.json") }}'
                        },
                    })
                }
            })
        }
        
        // ajax toke setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // tambah mata pelajaran
        $(document).on('submit', '#form-tambah-mapel', function(e){
            e.preventDefault()

            // hapus validasi
            var form = $('#form-tambah-mapel')
            form.find('.form-text').remove()

            // animasi
            let btn = document.getElementById('btn-tam-mapel')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading')
            loading.style.display = 'block'

            let formData = new FormData($('#form-tambah-mapel')[0])

            $.ajax({
                type: "POST",
                url: "/mata_pelajaran/tambah",
                data: formData,
                contentType: false,
                processData: false,
                success: function(){
                    $('#example').DataTable().destroy()
                    $('#nama_mata_pelajaran').val('')
                    $('#kode').val('')
                    ambilData()

                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)

                    // notifikasi
                    Toast.fire({
                        icon: 'success',
                        title: 'Mata pelajaran berhasil ditambahkan'
                    })
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

        // loading detail data modal edit
        function wait(){
            let wait = document.getElementById('wait')
            let btn = document.getElementById('btn-edi-mapel')
            wait.style.display = 'block'
            btn.setAttribute('disabled', true)
        }

        // hapus loading detail data modal edit
        function hapusWait(){
            let wait = document.getElementById('wait')
            let btn = document.getElementById('btn-edi-mapel')
            wait.style.display = 'none'
            btn.removeAttribute('disabled', false)
        }

        // ambil detail mapel untuk modal edit
        $(document).on('click', '.btn-edi-mapel', function(){
            wait()
            let id = $(this).attr('id')
            
            $.ajax({
                type: 'GET',
                url: 'mata_pelajaran/detail/'+id,
                success: function(response){
                    $('#id').val(response.mapel.id)
                    $('#kode_edit').val(response.mapel.kode)
                    $('#nama_mata_pelajaran_edit').val(response.mapel.nama_mata_pelajaran)
                    hapusWait()
                }
            })
        })

        // edit mata pelajaran
        $(document).on('submit', '#form-edit-mapel', function(e){
            e.preventDefault()

            // ambil id
            let id = $('#id').val()

            // hapus validasi
            var form = $('#form-edit-mapel')
            form.find('.form-text').remove()

            // animasi
            let btn = document.getElementById('btn-edi-mapel')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading-edit')
            loading.style.display = 'block'

            let formData = new FormData($('#form-edit-mapel')[0])

            $.ajax({
                type: "POST",
                url: "/mata_pelajaran/edit/"+id,
                data: formData,
                contentType: false,
                processData: false,
                success: function(){
                    $('#example').DataTable().destroy()
                    $('#nama_mata_pelajaran_edit').val('')
                    ambilData()

                    $('#btn-close-modal').click()

                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)

                    // notifikasi
                    Toast.fire({
                        icon: 'success',
                        title: 'Mata pelajaran berhasil diedit'
                    })
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

        // hapus validasi saat tutup modal edit
        function tutup_modal(){
            var form = $('#form-edit-mapel')
            form.find('.form-text').remove()
        }

        $(document).on('click', '#btn-close-modal', function(){
            tutup_modal()
        })

        // hapus mata pelajaran
        $(document).on('click', '.btn-hap-mapel', function(e){
            e.preventDefault()
            let id = $(this).attr('id')

            Swal.fire({
                title: 'Apa kamu yakin ?',
                text: "ingin menghapus mata pelajaran ini",
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
                    url: "mata_pelajaran/hapus/"+id,
                    success: function(){
                        $('#example').DataTable().destroy()
                        ambilData()
                        Toast.fire({
                            icon: 'success',
                            title: 'Mata pelajaran berhasil dihapus'
                        })
                    },
                    error: function(){
                        toastFail.fire({
                            icon: 'error',
                            title: 'Mata pelajaran gagal dihapus, masih ada siswa yang menggunakan mata pelajaran ini !'
                        })
                    }
                })

                }
            })
        })

    })
</script>
@endpush