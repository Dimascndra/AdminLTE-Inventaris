@extends('layouts.app')
@section('title', __('Laporan Barang'))
@section('content')
    <x-head-datatable />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-primary"><i class="fas fa-boxes mr-2"></i>
                            {{ __('Laporan Stok Barang') }}</h3>
                        <div class="card-tools d-flex">
                            <button class="btn btn-outline-primary btn-sm font-weight-bold mr-1" id="print">
                                <i class="fas fa-print mr-1"></i>{{ __('Print') }}
                            </button>
                            <button class="btn btn-outline-danger btn-sm font-weight-bold mr-1" id="export-pdf">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </button>
                            <button class="btn btn-outline-success btn-sm font-weight-bold" id="export-excel">
                                <i class="fas fa-file-excel mr-1"></i> Excel
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="bg-light p-3 rounded mb-4 border">
                            <h6 class="font-weight-bold mb-3 text-secondary"><i class="fas fa-filter mr-1"></i> Filter Data
                            </h6>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label for="day" class="small">{{ __('Tanggal') }}</label>
                                        <input type="number" name="day" class="form-control form-control-sm"
                                            placeholder="H" min="1" max="31">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label for="month" class="small">{{ __('Bulan') }}</label>
                                        <input type="month" name="month" class="form-control form-control-sm"
                                            title="Filter per Bulan">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label for="category_id" class="small">{{ __('Kategori') }}</label>
                                        <select name="category_id" class="form-control form-control-sm">
                                            <option value="">{{ __('Semua Kategori') }}</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label for="unit_id" class="small">{{ __('Lokasi') }}</label>
                                        <select name="unit_id" class="form-control form-control-sm">
                                            <option value="">{{ __('Semua Lokasi') }}</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-secondary btn-sm w-100 mb-2" id="reset-filter">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="data-tabel" width="100%"
                                class="table table-striped table-hover table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%" class="text-center">{{ __('No') }}</th>
                                        <th>{{ __('Kode Barang') }}</th>
                                        <th>{{ __('Tanggal Masuk') }}</th>
                                        <th>{{ __('Nama Barang') }}</th>
                                        <th class="text-center">{{ __('Stok Awal') }}</th>
                                        <th class="text-center">{{ __('Stok Akhir') }}</th>
                                        <th>{{ __('Kondisi') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-data-table />

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                const tabel = $('#data-tabel').DataTable({
                    lengthChange: true,
                    lengthMenu: [10, 25, 50, 100],
                    processing: true,
                    serverSide: true,
                    dom: 'lBfrtip',
                    ajax: {
                        url: `{{ route('laporan.stok.list') }}`,
                        data: function(d) {
                            d.day = $("input[name='day']").val(); // Ganti report_date jadi day
                            d.month = $("input[name='month']").val();
                            d.category_id = $("select[name='category_id']").val();
                            d.unit_id = $("select[name='unit_id']").val();
                        }
                    },
                    columns: [{
                            data: null,
                            sortable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: "kode_barang",
                            name: "kode_barang"
                        },
                        {
                            data: "tanggal_masuk",
                            name: "tanggal_masuk"
                        },
                        {
                            data: "nama_barang",
                            name: "nama_barang"
                        },
                        {
                            data: "stok_awal",
                            name: "stok_awal"
                        },
                        {
                            data: "total",
                            name: "total"
                        },
                        {
                            data: "condition",
                            name: "condition"
                        }
                    ],
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            className: 'd-none',
                            title: '',
                            customizeData: function(data) {
                                let filterInfo = [];
                                if ($("input[name='day']").val()) filterInfo.push("Tanggal: " + $(
                                    "input[name='day']").val());
                                if ($("input[name='month']").val()) filterInfo.push("Bulan: " + $(
                                    "input[name='month']").val());
                                data.header.splice(0, 0, "Laporan Stok Barang " + filterInfo.join(
                                    ', '));
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            className: 'd-none',
                            title: '',
                            customize: function(doc) {
                                let filterInfo = [];
                                if ($("input[name='day']").val()) filterInfo.push("Tanggal: " + $(
                                    "input[name='day']").val());
                                if ($("input[name='month']").val()) filterInfo.push("Bulan: " + $(
                                    "input[name='month']").val());

                                doc.content.splice(0, 0, {
                                    text: 'LAPORAN STOK BARANG\n' + filterInfo.join(', '),
                                    margin: [0, 0, 0, 10],
                                    alignment: 'center',
                                    fontSize: 12,
                                    bold: true
                                });
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'd-none',
                            title: '',
                            customize: function(win) {
                                let filterInfo = [];
                                if ($("input[name='day']").val()) filterInfo.push("Tanggal: " + $(
                                    "input[name='day']").val());
                                if ($("input[name='month']").val()) filterInfo.push("Bulan: " + $(
                                    "input[name='month']").val());

                                $(win.document.body)
                                    .prepend(
                                        '<div style="text-align:center;margin-bottom:10px;"><h3>LAPORAN STOK BARANG</h3><strong>' +
                                        filterInfo.join(', ') + '</strong></div>');
                            }
                        }
                    ]
                });

                // Tombol manual trigger export
                $("#print").on('click', function() {
                    tabel.button('.buttons-print').trigger();
                });
                $("#export-pdf").on('click', function() {
                    tabel.button('.buttons-pdf').trigger();
                });
                $("#export-excel").on('click', function() {
                    tabel.button('.buttons-excel').trigger();
                });

                // 🟢 FILTER DATA REALTIME
                // Trigger reload saat ada perubahan di input apapun
                $("input[name='day'], input[name='month'], select[name='category_id'], select[name='unit_id']")
                    .on('change keyup', function() { // Added keyup for better responsiveness
                        tabel.ajax.reload();
                    });

                // Tombol Reset
                $("#reset-filter").on('click', function() {
                    $("input[name='day']").val(''); // Reset day input
                    $("input[name='month']").val('');
                    $("select[name='category_id']").val('');
                    $("select[name='unit_id']").val('');
                    tabel.ajax.reload();
                });
            });
        </script>
    @endsection
