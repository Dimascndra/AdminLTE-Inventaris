@extends('layouts.app')
@section('title', __("Laporan Barang Baru"))
@section('content')
<x-head-datatable/>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Laporan Barang Baru (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kode</th>
                                <th>Stok Saat Ini</th>
                                <th>Tanggal Dibuat</th>
                                </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('laporan.barangbaru.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'item_name', name: 'item_name'},
            {data: 'code', name: 'code'},
            {data: 'quantity', name: 'quantity'},
            {data: 'date', name: 'date'},
        ]
    });
});
</script>
@endpush
@endsection
