<div>
    <div class="card border card-border-primary">
        <div class="card-header">
            <h6 class="fw-bold">Data Transaksi Pembelian Sparepart</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-2">
                        <label for="no_transaksi" class="form-label">Nomor Transaksi</label>
                        <input type="text" class="form-control" disabled value="{{ $no_transaksi }}">
                        <x-form.validation.error name="no_transaksi" />
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-2">
                        <label for="tgl_transaksi" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" wire:model.live="tgl_transaksi">
                        <x-form.validation.error name="tgl_transaksi" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-2">
                        <div wire:ignore>
                            <label for="id_supplier" class="form-label">Supplier</label>
                            <select name="id_supplier" id="id_supplier" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <x-form.validation.error name="supplier" />
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-2">
                        <label for="keterangan" class="form-label">Keterangan (boleh kosong)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" wire:model.live="keterangan"></textarea>
                        <x-form.validation.error name="keterangan" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card border card-border-primary">
                <div class="card-header">
                    <h6 class="fw-bold">Input Sparepart</h6>
                </div>
                <div class="card-body">
                    <div class="col">
                        <div class="mb-2">
                            <div wire:ignore>
                                <label for="kode_sparepart" class="form-label">Kode/Nama Barang</label>
                                <select name="id_sparepart" id="id_sparepart" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <x-form.validation.error name="kode_sparepart" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <div class="mb-2">
                                <label for="stok" class="form-label">Stok saat ini</label>
                                <input type="text" class="form-control" disabled value="{{ $stok }}">
                                <x-form.validation.error name="stok" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="buying_price" class="form-label">Harga beli dari supplier (Rp)</label>
                                <input type="text" class="form-control" wire:model.live="buying_price">
                                <x-form.validation.error name="buying_price" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" wire:model.live="jumlah">
                                <x-form.validation.error name="jumlah" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <span wire:click="tambahSparepart()" wire:target="tambahSparepart" class="btn btn-primary"
                                wire:loading.class="disabled">
                                <span wire:loading.remove wire:target="tambahSparepart">Tambah</span>
                                <span wire:loading wire:target="tambahSparepart">Proses...</span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card border card-border-primary">
                <div class="card-header">
                    <h6 class="fw-bold">Daftar Transaksi</h6>
                    <x-form.validation.error name="transaksi_temp" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped align-middle"
                            style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Sparepart</th>
                                    <th>Nama Sparepart</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php

                                    $a = 0;
                                @endphp
                                @forelse ($transaksi_temp as $key => $item)
                                    <tr>
                                        <td>{{ ++$a }}</td>
                                        <td>{{ $item['kode'] }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>{{ $item['harga'] }}</td>
                                        <td>{{ $item['jumlah'] }}</td>
                                        <td>{{ $item['sub_total'] }}</td>
                                        <td><span class="btn btn-danger btn-sm"
                                                wire:click="deleteTemp({{ $key }})">Hapus</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" align="center"> Belum ada transaksi !</td>
                                    </tr>
                                @endforelse

                                @if ($total)
                                    <tr class="bg-dark">
                                        <td colspan="5"></td>
                                        <td class="text-white">Total: </td>
                                        <td colspan="2" class="text-white">Rp. {{ $total }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5"></td>
                                        <td>Jumlah Bayar: (Rp.)</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" wire:model.live="jml_bayar">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td>Kembalian: (Rp.)</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" disabled
                                                value="{{ $kembalian }}">
                                        </td>
                                    </tr> --}}
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        @if ($errors->any())
            <span class="text-danger text-sm my-2">Periksa kembali, lengkapi data transaksi terlebih dahulu !</span>
        @endif
        <div class="d-grid gap-2">
            <span wire:click="proses()" wire:target="proses" class="btn btn-success fw-bold"
                wire:loading.class="disabled">
                <span wire:loading.remove wire:target="proses">Simpan Transaksi</span>
                <span wire:loading wire:target="proses">Simpan Transaksi...</span>
            </span>
        </div>
    </div>


    <!-- Modals add menu -->
    <div id="modal-alert" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-alert"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-alert">Berhasil Memproses Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Transaksi berhasil disimpan !</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('transaksi.cetak', ['id' => $proses_id]) }}" target="_blank"
                        class="btn btn-success mb-2">Cetak</a>
                    <a href="{{ route('restock.index') }}" class="btn btn-info">
                        Kembali
                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#id_sparepart").select2({
            ajax: {
                delay: 250,
                url: "{{ route('ajax.sparepart') }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'user_search'
                    }

                    // Query parameters will be ?search=[term]&type=user_search
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            cache: true,
            placeholder: 'Pilih atau masukkan kode/nama sparepart',
            // minimumInputLength: 3
        });

        $('#id_sparepart').on('change', function(e) {
            const kode_sparepart = $('#id_sparepart').select2("val");
            @this.set('kode_sparepart', kode_sparepart);
        });

        $("#id_supplier").select2({
            ajax: {
                delay: 250,
                url: "{{ route('ajax.supplier') }}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'user_search'
                    }

                    // Query parameters will be ?search=[term]&type=user_search
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            cache: true,
            placeholder: 'Pilih atau masukkan supplier',
            // minimumInputLength: 3
        });

        $('#id_supplier').on('change', function(e) {
            const supplier = $('#id_supplier').select2("val");
            @this.set('supplier', supplier);
        });

        document.addEventListener('empty-sparepart-form', function(e) {
            // Swal.fire({
            //     title: "Berhasil",
            //     text: "Berhasil menambahkan transaksi",
            //     icon: "success",
            // });
            Toastify({
                text: "Berhasil <br> Berhasil menambahkan transaksi !",
                duration: 3000,
                // destination: "https://github.com/apvarun/toastify-js",
                // newWindow: true,
                className: "bg-warning",
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                // style: {
                //     // background: "linear-gradient(to right, #00b09b, #96c93d)",
                // },
                onClick: function() {} // Callback after click
            }).showToast();

            $("#id_sparepart").select2('destroy');

            $("#id_sparepart").select2({
                ajax: {
                    delay: 250,
                    url: "{{ route('ajax.sparepart') }}",
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'user_search'
                        }

                        // Query parameters will be ?search=[term]&type=user_search
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: true,
                placeholder: 'Pilih atau masukkan kode/nama sparepart',
                // minimumInputLength: 3
            }).val("").trigger('change');

            $('#id_sparepart').on('change', function(e) {
                const kode_sparepart = $('#id_sparepart').select2("val");
                @this.set('kode_sparepart', kode_sparepart);
            });
        });


        document.addEventListener('show-alert', function(e) {
            $('#modal-alert').modal('show');
        })
    </script>
@endpush
