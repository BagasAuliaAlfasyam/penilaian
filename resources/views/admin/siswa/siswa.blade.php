@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Siswa</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('siswa') }}">siswa</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <a href="{{ url('siswa/tambah') }}" class="btn btn-sm btn-primary float-end">Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-siswa">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Wali</th>
                                <th>Telepon Wali</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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

            // ambil data siswa
            $('#tab-siswa').DataTable({
                language: {
                    url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
                },
                serverSide: true,
                responsive: true,
                ajax: {
                    url: 'siswa',
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'nisn',
                        name: 'nisn'
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'wali',
                        name: 'wali'
                    },
                    {
                        data: 'telepon_wali',
                        name: 'telepon_wali'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
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
            });

            // hapus siswa
            $(document).on('click', '.hapus-siswa', function() {
                let id = $(this).attr('id')

                Swal.fire({
                    title: 'Apa kamu yakin ?',
                    text: "ingin menghapus siswa ini",
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
                            url: "/siswa/delete/" + id,
                            success: function() {
                                $('#tab-siswa').DataTable().ajax.reload()
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Siswa berhasil dihapus'
                                })
                            },
                            error: function() {
                                toastFail.fire({
                                    icon: 'error',
                                    title: 'Siswa gagal dihapus, ada data yang berelasi dengan siswa ini'
                                })
                            }
                        })

                    }
                })
            })

        })
    </script>
@endpush
