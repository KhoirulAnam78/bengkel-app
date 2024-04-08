<!-- Modals add menu -->
<div id="modal-form-add" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-form-add"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add">Tambah Data Supplier </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Supplier </label>
                                <input type="text" class="form-control" placeholder="Masukkan nama Supplier"
                                    wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No Hp </label>
                                <input type="text" class="form-control" placeholder="Masukkan No Hp"
                                    wire:model.live="no_telp">
                                <x-form.validation.error name="no_telp" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" placeholder="Alamat Supplier" wire:model.live="alamat" rows="5"></textarea>
                        <x-form.validation.error name="alamat" />
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
                    <h5 class="modal-title" id="modal-form-edit">Edit Supplier </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>



                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Supplier </label>
                                <input type="text" class="form-control" placeholder="Masukkan nama Supplier"
                                    wire:model.live="name">
                                <x-form.validation.error name="name" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No Hp </label>
                                <input type="text" class="form-control" placeholder="Masukkan No Hp"
                                    wire:model.live="no_telp">
                                <x-form.validation.error name="no_telp" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" placeholder="Alamat Supplier" wire:model.live="alamat" rows="5"></textarea>
                        <x-form.validation.error name="alamat" />
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
                <h5 class="modal-title" id="modal-form-delete">Hapus Supplier</h5>
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
