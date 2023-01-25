@extends('layout/dashboard')

@section('konten')
    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Guru</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('guru') }}">guru</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <a href="{{ url('guru/tambah') }}" class="btn btn-sm btn-primary float-end">Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-guru">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
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

            // ambil data guru
            $('#tab-guru').DataTable({
                language: {
                    url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
                },
                serverSide: true,
                responsive: true,
                ajax: {
                    url: 'guru',
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'nip',
                        name: 'nip'
                    },
                    {
                        data: 'nama_guru',
                        name: 'nama_guru'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'telepon',
                        name: 'telepon'
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

            // hapus guru
            $(document).on('click', '.hapus-guru', function() {
                let id = $(this).attr('id')

                Swal.fire({
                    title: 'Apa kamu yakin ?',
                    text: "ingin menghapus guru ini",
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
                            url: "/guru/delete/" + id,
                            success: function() {
                                $('#tab-guru').DataTable().ajax.reload()
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Guru berhasil dihapus'
                                })
                            },
                            error: function() {
                                toastFail.fire({
                                    icon: 'error',
                                    title: 'Guru gagal dihapus, ada data yang berelasi dengan guru ini'
                                })
                            }
                        })

                    }
                })
            })

        })
    </script>
@endpush
