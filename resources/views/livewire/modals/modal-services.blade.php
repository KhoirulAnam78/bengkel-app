<!-- Modals add menu -->
<div id="modal-form-add" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-add"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add">Tambah Data Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Service</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama service/sparepart"
                                    wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode service</label>
                                <input type="text" class="form-control" placeholder="Masukkan kode service"
                                    wire:model.live="code">
                                <x-form.validation.error name="code" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" placeholder="Masukkan biaya service" class="form-control"
                                wire:model.live="price">
                            <x-form.validation.error name="price" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptions" class="form-label">Keterangan</label>
                        <textarea name="descriptions" class="form-control" placeholder="Keterangan sparepart/service"
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
                    <h5 class="modal-title" id="modal-form-edit">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>



                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Service</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama service/sparepart"
                                    wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode service</label>
                                <input type="text" disabled class="form-control"
                                    placeholder="Masukkan kode service" wire:model.live="code">
                                <x-form.validation.error name="code" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" placeholder="Masukkan biaya service" class="form-control"
                                wire:model.live="price">
                            <x-form.validation.error name="price" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descriptions" class="form-label">Keterangan</label>
                        <textarea name="descriptions" class="form-control" placeholder="Keterangan sparepart/service"
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
                <h5 class="modal-title" id="modal-form-delete">Hapus Services</h5>
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
                    <h5 class="modal-title" id="modal-form-import">Tambah Data Service </h5>
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
                        <span>Siapkan data dengan format seperti berikut !</span>
                        <br>
                        <span>Catatan : *Kolom keterangan boleh kosong</span>
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <td>Kode</td>
                                    <td>Nama</td>
                                    <td>Harga</td>
                                    <td>Keterangan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Paket Service Beat</td>
                                    <td>100000</td>
                                    <td>Layanan full service honda beat</td>
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
