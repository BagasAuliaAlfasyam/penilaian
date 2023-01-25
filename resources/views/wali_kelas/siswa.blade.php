@extends('layout/dashboard')

@section('konten')
    <input type="hidden" id="route_id" value="{{ $route_id }}">

    <div class="container-fluid px-4">
        <div class="content-top">
            <h1 style="font-size:20px;">Siswa</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('kelasku') }}">kelasku</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('kelasku/' . $route_id . '/siswa') }}">siswa</a></li>
            </ol>
        </div>
        <div class="row" style="padding:0 10px;">
            <div class="col-12 col-md-12 bg-table">
                <div class="row mb-3">
                    <div class="col">
                        <div class="float-end">
                            <a href="{{ url('kelasku') }}" class="btn btn-sm btn-dark me-1">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table" style="font-size:14px;" id="tab-siswa">
                        <thead>
                            <tr style="border-bottom:2px solid #5034FF;">
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Kelakuan</th>
                                <th>Kerajinan</th>
                                <th>Kebersihan</th>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alpha</th>
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
        var route_id = $('#route_id').val()

        // ambil data wali kelas
        $('#tab-siswa').DataTable({
            language: {
                url: '{{ asset('plugins/datatable-bahasa/bahasa-indonesia.json') }}'
            },
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/kelasku/' + route_id + '/siswa',
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'siswa',
                    name: 'siswa'
                },
                {
                    data: 'kelakuan',
                    name: 'kelakuan'
                },
                {
                    data: 'kerajinan',
                    name: 'kerajinan'
                },
                {
                    data: 'kebersihan',
                    name: 'kebersihan'
                },
                {
                    data: 'sakit',
                    name: 'sakit'
                },
                {
                    data: 'izin',
                    name: 'izin'
                },
                {
                    data: 'alpha',
                    name: 'alpha'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        })
    </script>
@endpush
