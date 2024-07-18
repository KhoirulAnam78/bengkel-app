<!-- Modals add menu -->
<div id="modal-form-add" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-add"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add">Tambah Data Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Sparepart</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama barang/sparepart"
                                    wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" placeholder="Masukkan kode barang"
                                    wire:model.live="code">
                                <x-form.validation.error name="code" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="id_jenis" class="form-label">Jenis Motor (opsional)</label>
                                <select class="form-select mb-3" aria-label="Jenis Motor" wire:model.live="id_jenis">
                                    <option value="">Pilih</option>
                                    @foreach ($jenisMotor as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <x-form.validation.error name="id_jenis" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukkan satuan sparepart (unit, pack dll)" wire:model.live="satuan">
                                <x-form.validation.error name="satuan" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukkan jumlah barang tersedia saat ini" wire:model.live="stok">
                                <x-form.validation.error name="stok" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="buying_price" class="form-label">Harga Modal</label>
                                <input type="text" placeholder="Masukkan harga modal/harga beli" class="form-control"
                                    wire:model.live="buying_price">
                                <x-form.validation.error name="buying_price" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="selling_price" class="form-label">Harga Jual</label>
                                <input type="text" placeholder="Masukkan harga jual ke pelanggan"
                                    class="form-control" wire:model.live="selling_price">
                                <x-form.validation.error name="selling_price" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="reseller_price" class="form-label">Harga Jual (Ke Reseller)</label>
                                <input type="text" placeholder="Masukkan harga jual ke pelanggan"
                                    class="form-control" wire:model.live="reseller_price">
                                <x-form.validation.error name="reseller_price" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptions" class="form-label">Keterangan</label>
                        <textarea name="descriptions" class="form-control" placeholder="Keterangan sparepart/barang"
                            wire:model.live="descriptions" rows="5"></textarea>
                        <x-form.validation.error name="descriptions" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        wire:click="empty()">Close</button>
                    <span wire:click="save()" class="btn btn-primary" wire:loading.class="disabled">
                        <span wire:loading.remove wire:target="save">Tambah</span>
                        <span wire:loading wire:target="save">Proses...</span>
                    </span>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-form-edit" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-edit"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit">Edit Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>


                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Sparepart</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukkan nama barang/sparepart" wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" disabled
                                    placeholder="Masukkan kode barang" wire:model.live="code">
                                <x-form.validation.error name="code" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="id_jenis" class="form-label">Jenis Motor (opsional)</label>
                                <select class="form-select mb-3" aria-label="Jenis Motor" wire:model.live="id_jenis">
                                    <option value="">Pilih</option>
                                    @foreach ($jenisMotor as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <x-form.validation.error name="id_jenis" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukkan satuan sparepart (unit, pack dll)" wire:model.live="satuan">
                                <x-form.validation.error name="satuan" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="text" class="form-control"
                                    placeholder="Masukkan jumlah barang tersedia saat ini" wire:model.live="stok">
                                <x-form.validation.error name="stok" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="buying_price" class="form-label">Harga Modal</label>
                                <input type="text" placeholder="Masukkan harga modal/harga beli"
                                    class="form-control" wire:model.live="buying_price">
                                <x-form.validation.error name="buying_price" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="selling_price" class="form-label">Harga Jual</label>
                                <input type="text" placeholder="Masukkan harga jual ke pelanggan"
                                    class="form-control" wire:model.live="selling_price">
                                <x-form.validation.error name="selling_price" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="reseller_price" class="form-label">Harga Jual (Ke Reseller)</label>
                                <input type="text" placeholder="Masukkan harga jual ke reseller"
                                    class="form-control" wire:model.live="reseller_price">
                                <x-form.validation.error name="reseller_price" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptions" class="form-label">Keterangan</label>
                        <textarea name="descriptions" class="form-control" placeholder="Keterangan sparepart/barang"
                            wire:model.live="descriptions" rows="5"></textarea>
                        <x-form.validation.error name="descriptions" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        wire:click="empty()">Close</button>
                    <span wire:click="update()" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="update">Update</span>
                        <span wire:loading wire:target="update">Proses...</span>
                    </span>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modals add menu -->
<div id="modal-form-delete" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-delete"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-delete">Hapus Spareparts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="empty()"> </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p>Benar ingin menghapus data ?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                    wire:click="empty()">Close</button>
                <span wire:click="delete()" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="delete">Hapus</span>
                    <span wire:loading wire:target="delete">Proses...</span>
                </span>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="modal-form-import" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-import"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-import">Import Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File Excel</label>
                        <input type="file" accept=".xlsx,.xls,.csv" class="form-control" wire:model="file">
                        <x-form.validation.error name="file" />
                    </div>
                    <span class="text-success" wire:target="file" wire:loading>Mengupload...</span>
                    <div class="mb-3">
                        <span>Siapkan data excel dengan format seperti berikut !</span>
                        <br>
                        <span>Catatan : *Kolom keterangan,*Harga reseller, *Jenis Motor boleh kosong</span>
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <td>Kode</td>
                                    <td>Nama</td>
                                    <td>Satuan</td>
                                    <td>Jenis Motor</td>
                                    <td>Harga Modal</td>
                                    <td>Harga Jual</td>
                                    <td>Harga Reseller</td>
                                    <td>Keterangan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Oli Mpx</td>
                                    <td>Botol</td>
                                    <td>Honda</td>
                                    <td>50000</td>
                                    <td>60000</td>
                                    <td>55000</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        wire:click="empty()">Close</button>
                    <span wire:click="import()" class="btn btn-primary" iwre:target="import"
                        wire:loading.class="disabled">
                        <span wire:loading.remove wire:target="import">Import</span>
                        <span wire:loading wire:target="import">Proses...</span>
                    </span>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
