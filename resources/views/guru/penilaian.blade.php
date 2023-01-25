@extends('layout/dashboard')

@section('konten')
<div class="container-fluid px-4">
    <div class="content-top">
        <h1 style="font-size:20px;">Penilaian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ url('penilaian') }}">penilaian</a></li>
        </ol>
    </div> 
    <div class="row" style="padding:0 10px;">
        <div class="col-12 col-md-12 bg-table">
            <div class="row">
                <table class="table" style="font-size:14px;" id="tab-penilaian">
                    <thead>
                        <tr style="border-bottom:2px solid #5034FF;">
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Mapel</th>
                            <th>Kelas</th>
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
    $(document).ready(function(){

        // ambil data penilaian
        $('#tab-penilaian').DataTable({
            language: {
                url: '{{ asset("plugins/datatable-bahasa/bahasa-indonesia.json") }}'
            },
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/penilaian',
            },
            columns: [
                {data: 'tahun_pelajaran', name: 'tahun_pelajaran'},
                {data: 'semester', name: 'semester'},
                {data: 'mapel', name: 'mapel'},
                {data: 'kelas', name: 'kelas'},
                {data: 'action', name: 'action'}
            ]
        })

    })
</script>
@endpush