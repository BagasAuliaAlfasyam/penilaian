@extends('layout/dashboard')

@section('konten')
<div class="container-fluid px-4">
    <div class="content-top">
        <h1 style="font-size:20px;">Ubah Password</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('ubah_password') }}">Ubah Password</a></li>
        </ol>
    </div>
    <div class="row" style="padding:0 10px;">
        <div class="col-12 col-md-5 bg-table">

            <div class="pesan"></div>
            
            <form action="" id="form-ubah-password">
                <div class="form-group mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control fc-edited">
                </div>
                <div class="form-group mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control fc-edited">
                </div>

                <button class="btn btn-sm btn-primary float-end d-flex" id="btn-ubah-password">
                   <div>Ubah password</div>
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
@endsection

@push('script')
<script>
    $(document).ready(function(){

        // ajax toke setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // tambah siswa
        $(document).on('submit', '#form-ubah-password', function(e){
            e.preventDefault()

            // hapus validasi
            var form = $('#form-ubah-password')
            form.find('.form-text').remove()

            // animasi
            let btn = document.getElementById('btn-ubah-password')
            btn.setAttribute('disabled', true)
            let loading = document.getElementById('loading')
            loading.style.display = 'block'

            let formData = new FormData($('#form-ubah-password')[0])

            $.ajax({
                type: "POST",
                url: "/ubah_password",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){

                    // notifikasi
                    $('.pesan').append('<div class="alert alert-success">'+response.message+'</div>')

                    // hilangkan input field
                    $('#password').val('')
                    $('#konfirmasi_password').val('')

                    // hilangkan animasi
                    loading.style.display = 'none'
                    btn.removeAttribute('disabled', false)
                    
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

    })
</script>
@endpush