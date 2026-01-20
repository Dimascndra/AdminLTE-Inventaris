@extends('layouts.app')
@section('title', __('Data Barang'))
@section('content')
    <x-head-datatable />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card w-100">
                    <div class="card-header row">
                        <div class="d-flex justify-content-end align-items-center w-100">
                            @if (Auth::user()->role->name != 'staff' && Auth::user()->role->name != 'pimpinan')
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#TambahData"
                                    id="modal-button"><i class="fas fa-plus"></i> {{ __('tambah data') }}</button>
                            @endif
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="TambahData" tabindex="-1" aria-labelledby="TambahDataModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="TambahDataModalLabel">{{ __('tambah barang') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="kode" class="form-label">{{ __('kode barang') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="kode" readonly class="form-control">
                                                <input type="hidden" name="id" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    {{ __('tanggal masuk') }} <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" name="tanggal_masuk" class="form-control"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama" class="form-label">{{ __('nama barang') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="nama" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="jenisbarang" class="form-label">{{ __('kategori barang') }}
                                                    <span class="text-danger">*</span></label>
                                                <select name="jenisbarang" class="form-control">
                                                    <option value="">-- {{ __('pilih kategori') }} --</option>
                                                    @foreach ($jenisbarang as $jb)
                                                        <option value="{{ $jb->id }}">{{ $jb->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="satuan" class="form-label">{{ __('lokasi barang') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="satuan" class="form-control">
                                                    <option value="">-- {{ __('pilih lokasi') }} --</option>
                                                    @foreach ($satuan as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="merk" class="form-label">{{ __('merek barang') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="merk" class="form-control">
                                                    <option value="">-- {{ __('pilih merek') }} --</option>
                                                    @foreach ($merk as $m)
                                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group item-count" id="item-count">
                                                <label for="harga" class="form-label">{{ __('jumlah') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" value="0" name="jumlah" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="harga" class="form-label">{{ __('harga') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="harga" name="harga" class="form-control"
                                                    placeholder="RP. 0">
                                            </div>
                                            <!-- Tambahan baru -->
                                            <div class="form-group">
                                                <label for="condition" class="form-label">{{ __('kondisi') }}</label>
                                                <select name="condition" class="form-control">
                                                    <option value="Baik">Baik</option>
                                                    <option value="Rusak">Rusak</option>
                                                    <option value="Hilang">Hilang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="title" class="form-label">{{ __('photo') }}</label>
                                                <img src="{{ asset('default.png') }}" width="80%" alt="profile-user"
                                                    id="outputImg" class="text-center">
                                                <input class="form-control mt-5" id="GetFile" name="photo"
                                                    type="file" accept=".png,.jpeg,.jpg,.svg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        id="kembali">{{ __('back') }}</button>
                                    <button type="button" class="btn btn-success" id="simpan"
                                        data-mode="create">{{ __('save') }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-tabel" width="100%"
                                class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" width="8%">{{ __('no') }}</th>
                                        <th class="border-bottom-0">{{ __('photo') }}</th>
                                        <th class="border-bottom-0">{{ __('kode') }}</th>
                                        <th>{{ __('tanggal masuk') }}</th>
                                        <th class="border-bottom-0">{{ __('nama') }}</th>
                                        <th class="border-bottom-0">{{ __('kategori') }}</th>
                                        <th class="border-bottom-0">{{ __('lokasi') }}</th>
                                        <th class="border-bottom-0">{{ __('merek') }}</th>
                                        <th class="border-bottom-0">{{ __('jumlah') }}</th>
                                        <th class="border-bottom-0">{{ __('harga') }}</th>
                                        <th class="border-bottom-0">{{ __('kondisi') }}</th> <!-- tambahan -->
                                        @if (Auth::user()->role->name != 'staff' && Auth::user()->role->name != 'pimpinan')
                                            <th class="border-bottom-0" width="1%">{{ __('aksi') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
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

        function harga() {
            this.value = formatIDR(this.value.replace(/[^0-9.]/g, ''));
        }


        function formatIDR(angka) {
            // Ubah angka menjadi string dan hapus simbol yang tidak diperlukan
            var strAngka = angka.toString().replace(/[^0-9]/g, '');

            // Jika tidak ada angka yang tersisa, kembalikan string kosong
            if (!strAngka) return '';

            // Pisahkan angka menjadi bagian yang sesuai dengan ribuan
            var parts = strAngka.split('.');
            var intPart = parts[0];
            var decPart = parts.length > 1 ? '.' + parts[1] : '';

            // Tambahkan pemisah ribuan
            intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Tambahkan simbol IDR
            return 'RP.' + intPart + decPart;
        }

        function isi() {
            $('#data-tabel').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: `{{ route('barang.list') }}`,
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'img',
                        name: 'img'
                    }, {
                        data: 'code',
                        name: 'code'
                    }, {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    }, {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'unit_name',
                        name: 'unit_name'
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'condition',
                        name: 'condition'
                    },
                    @if (Auth::user()->role->name != 'staff' && Auth::user()->role->name != 'pimpinan')
                        {
                            data: 'tindakan',
                            name: 'tindakan'
                        }
                    @endif
                ]
            }).buttons().container();
        }

        function simpan() {
            const name = $("input[name='nama']").val();
            const code = $("input[name='kode']").val();
            const tanggal_masuk = $("input[name='tanggal_masuk']").val();
            const image = $("#GetFile")[0].files;
            const category_id = $("select[name='jenisbarang']").val();
            const unit_id = $("select[name='satuan']").val();
            const brand_id = $("select[name='merk']").val();
            const price = $("input[name='harga']").val();
            const quantity = $("input[name='jumlah']").val();
            const condition = $("select[name='condition']").val(); //baru
            // return console.log({name,code,category_id,unit_id,brand_id,price,quantity});
            const Form = new FormData();
            if (image.length > 0) { // ✅ FIX
                Form.append('image', image[0]);
            }
            Form.append('code', code);
            Form.append('tanggal_masuk', tanggal_masuk);
            Form.append('name', name);
            Form.append('category_id', category_id);
            Form.append('unit_id', unit_id);
            Form.append('brand_id', brand_id);
            Form.append('price', price);
            Form.append('quantity', quantity);
            Form.append('condition', condition); //baru
            if (name.length == 0) {
                return Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "nama tidak boleh kosong !",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (price.length == 0) {
                return Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "harga tidak boleh kosong !",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (!tanggal_masuk) {
                return Swal.fire({
                    icon: "warning",
                    title: "Tanggal masuk wajib diisi!",
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            $.ajax({
                url: `{{ route('barang.save') }}`,
                type: "post",
                processData: false,
                contentType: false,
                dataType: 'json',
                data: Form,
                success: function(res) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#kembali').click();
                    $("input[name='nama']").val(null);
                    $("input[name='kode']").val(null);
                    $("input[name='tanggal_masuk']").val(null); // ✅ FIX
                    $("#GetFile").val = null;
                    $("select[name='jenisbarang']").val(null);
                    $("select[name='satuan']").val(null);
                    $("select[name='merk']").val(null);
                    $("input[name='jumlah']").val(0);
                    $("input[name='harga']").val(null);
                    $('#data-tabel').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.log(err);
                },

            });
        }


        function ubah() {
            const name = $("input[name='nama']").val();
            const code = $("input[name='kode']").val();
            const tanggal_masuk = $("input[name='tanggal_masuk']").val();
            const image = $("#GetFile")[0].files;
            const category_id = $("select[name='jenisbarang']").val();
            const unit_id = $("select[name='satuan']").val();
            const brand_id = $("select[name='merk']").val();
            const price = $("input[name='harga']").val();
            const quantity = $("input[name='jumlah']").val();
            const condition = $("select[name='condition']").val(); //baru
            // return console.log({name,code,category_id,unit_id,brand_id,price,quantity});
            const Form = new FormData();
            Form.append('id', $("input[name='id']").val());
            if (image.length > 0) { // ✅ FIX
                Form.append('image', image[0]);
            }
            Form.append('code', code);
            Form.append('tanggal_masuk', tanggal_masuk);
            Form.append('name', name);
            Form.append('category_id', category_id);
            Form.append('unit_id', unit_id);
            Form.append('brand_id', brand_id);
            Form.append('quantity', quantity);
            Form.append('price', price);
            Form.append('condition', condition); // baru
            $.ajax({
                url: `{{ route('barang.update') }}`,
                type: "post",
                contentType: false,
                processData: false,
                dataType: 'json',
                data: Form,
                success: function(res) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#kembali').click();
                    $("input[name='id']").val(null);
                    $("input[name='nama']").val(null);
                    $("input[name='kode']").val(null);
                    $("input[name='tanggal_masuk']").val(null); // ✅ FIX
                    $("#GetFile").val(null);
                    $("select[name='jenisbarang']").val(null);
                    $("select[name='satuan']").val(null);
                    $("select[name='merk']").val(null);
                    $("input[name='jumlah']").val(0);
                    $("input[name='harga']").val(null);
                    $('#data-tabel').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.log(err);
                },


            });
        }

        $(document).ready(function() {
            $("#harga").on("input", harga);
            isi();

            $('#simpan').on('click', function() {
                if ($(this).text() === 'Simpan Perubahan') {
                    ubah();
                } else {
                    simpan();
                }
            });

            $("#modal-button").on("click", function() {
                $("#item-count").show();
                $("input[name='nama']").val(null);
                $("input[name='id']").val(null);
                $("input[name='kode']").val(null);
                $("input[name='tanggal_masuk']").val(null); // ✅ FIX
                $("#GetFile").val(null);
                $("select[name='jenisbarang']").val(null);
                $("select[name='satuan']").val(null);
                $("select[name='merk']").val(null);
                $("input[name='jumlah']").val(0);
                $("input[name='harga']").val(null);
                $("#simpan").text("Simpan");
                id = new Date().getTime();
                $("input[name='kode']").val("BRG-" + id);
            });


        });



        $(document).on("click", ".ubah", function() {
            let id = $(this).attr('id');
            $("#modal-button").click();
            $("#item-count").show();
            $("#simpan").text("Simpan Perubahan");
            $.ajax({
                url: "{{ route('barang.detail') }}",
                type: "post",
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function({
                    data
                }) {
                    $("input[name='id']").val(data.id);
                    $("input[name='nama']").val(data.name);
                    $("input[name='kode']").val(data.code);
                    $("input[name='tanggal_masuk']").val(data.tanggal_masuk);
                    $("select[name='jenisbarang']").val(data.category_id);
                    $("select[name='satuan']").val(data.unit_id);
                    $("select[name='merk']").val(data.brand_id);
                    $("input[name='jumlah']").val(data.quantity);
                    $("input[name='harga']").val(data.price);
                    $("select[name='condition']").val(data.condition); // baru
                }
            });


        });

        $(document).on("click", ".hapus", function() {
            let id = $(this).attr('id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-1",
                    cancelButton: "btn btn-danger m-1"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Anda Yakin ?",
                text: "Data Ini Akan Di Hapus",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya,Hapus",
                cancelButtonText: "Tidak, Kembali!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('barang.delete') }}",
                        type: "delete",
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#data-tabel').DataTable().ajax.reload();
                        }
                    });
                }
            });


        });
    </script>

@endsection
