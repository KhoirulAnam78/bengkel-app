<div>
    <div class="card border card-border-primary">
        <div class="card-header">
            <h6 class="fw-bold">Data Transaksi Pelanggan</h6>
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
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" wire:model.live="nama_pelanggan">
                        <x-form.validation.error name="nama_pelanggan" />
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
        <div class="col-lg-6 col-sm-12">
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
                                <label for="stok" class="form-label">Stok</label>
                                <input type="text" class="form-control" disabled value="{{ $stok }}">
                                <x-form.validation.error name="stok" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="selling_price" class="form-label">Harga Jual (Rp)</label>
                                <input type="text" class="form-control" wire:model.live="selling_price">
                                <x-form.validation.error name="selling_price" />
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
        <div class="col-lg-6 col-sm-12">
            <div class="card border card-border-primary">
                <div class="card-header">
                    <h6 class="fw-bold">Input Jasa Service</h6>
                </div>
                <div class="card-body">
                    <div class="col">
                        <div class="mb-2">
                            <div class="div" wire:ignore>
                                <label for="kode_service" class="form-label">Kode/Nama Jasa Service</label>
                                <select name="id_service" id="id_service" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <x-form.validation.error name="kode_service" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <label for="harga_service" class="form-label">Harga Service (Rp)</label>
                                <input type="text" class="form-control" wire:model.live="harga_service">
                                <x-form.validation.error name="harga_service" />
                            </div>
                        </div>
                        {{-- <div class="col-6">
                            <div class="mb-2">
                                <label for="diskon" class="form-label">Diskon (%)</label>
                                <input type="text" class="form-control" wire:model.live="diskon">
                                <x-form.validation.error name="diskon" />
                            </div>
                        </div> --}}
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <div wire:ignore>
                                <label for="mekanik" class="form-label">Mekanik</label>
                                <select name="id_mekanik" id="id_mekanik" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <x-form.validation.error name="mekanik" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <span wire:click="tambahService()" wire:target="tambahService" class="btn btn-primary"
                                wire:loading.class="disabled">
                                <span wire:loading.remove wire:target="tambahService">Tambah</span>
                                <span wire:loading wire:target="tambahService">Proses...</span>
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
                    <table id="example" class="table table-bordered table-striped align-middle" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Kode Sparepart/Service</th>
                                <th>Nama Service/Sparepart</th>
                                <th>Keterangan</th>
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
                                    <td>{{ $item['keterangan'] }}</td>
                                    <td>{{ $item['harga'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                    <td>{{ $item['sub_total'] }}</td>
                                    <td><span class="btn btn-danger btn-sm"
                                            wire:click="deleteTemp({{ $key }})">Hapus</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" align="center"> Tidak ada sparepart/service !</td>
                                </tr>
                            @endforelse

                            @if ($total)
                                <tr class="bg-dark">
                                    <td colspan="5"></td>
                                    <td class="text-white">Total: </td>
                                    <td colspan="2" class="text-white">Rp. {{ $total }}</td>
                                </tr>
                                <tr>
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
                                </tr>
                            @endif

                        </tbody>
                    </table>
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
                <span wire:loading.remove wire:target="proses">Proses Transaksi</span>
                <span wire:loading wire:target="proses">Proses Transaksi...</span>
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
                    <span wire:click="cetak()" class="btn btn-success" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="cetak">Cetak</span>
                        <span wire:loading wire:target="cetak">Proses...</span>
                    </span>
                    <a href="{{ route('transaksi.bengkel') }}" class="btn btn-success">
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

        $("#id_service").select2({
            ajax: {
                delay: 250,
                url: "{{ route('ajax.service') }}",
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
            placeholder: 'Pilih atau masukkan kode/nama service',
            // minimumInputLength: 3
        });

        $('#id_service').on('change', function(e) {
            const kode_service = $('#id_service').select2("val");
            @this.set('kode_service', kode_service);
        });

        $("#id_mekanik").select2({
            ajax: {
                delay: 250,
                url: "{{ route('ajax.mekanik') }}",
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
            placeholder: 'Pilih atau masukkan nama mekanik',
            // minimumInputLength: 3
        });

        $('#id_mekanik').on('change', function(e) {
            const mekanik = $('#id_mekanik').select2("val");
            @this.set('mekanik', mekanik);
        });

        document.addEventListener('empty-sparepart-form', function(e) {
            Swal.fire({
                title: "Berhasil",
                text: "Berhasil menambahkan transaksi",
                icon: "success",
            });

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


        document.addEventListener('empty-service-form', function(e) {
            Swal.fire({
                title: "Berhasil",
                text: "Berhasil menambahkan transaksi",
                icon: "success",
            });
            $("#id_mekanik").select2('destroy');

            $("#id_mekanik").select2({
                ajax: {
                    delay: 250,
                    url: "{{ route('ajax.mekanik') }}",
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
                placeholder: 'Pilih atau masukkan nama mekanik',
                // minimumInputLength: 3
            }).val("").trigger('change');

            $('#id_mekanik').on('change', function(e) {
                const mekanik = $('#id_mekanik').select2("val");
                @this.set('mekanik', mekanik);
            });

            $("#id_service").select2('destroy');

            $("#id_service").select2({
                ajax: {
                    delay: 250,
                    url: "{{ route('ajax.service') }}",
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
                placeholder: 'Pilih atau masukkan kode/nama service',
                // minimumInputLength: 3
            }).val("").trigger('change');;

            $('#id_service').on('change', function(e) {
                const kode_service = $('#id_service').select2("val");
                @this.set('kode_service', kode_service);
            });
        })

        document.addEventListener('show-alert', function(e) {
            $('#modal-alert').modal('show');
        })
    </script>
@endpush
