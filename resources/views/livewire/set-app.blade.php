<div>
    <div class="mb-3">
        <label for="role" class="form-label">Nama Aplikasi</label>
        <input type="text" class="form-control" name="app_name" id="app_name" wire:model.live="app_name">
        <x-form.validation.error name="app_name" />
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Alamat</label>
        <input type="text" class="form-control" name="alamat" id="alamat" wire:model.live="alamat">
        <x-form.validation.error name="alamat" />
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">No Hp</label>
        <input type="text" class="form-control" name="no_hp" id="no_hp" wire:model.live="no_hp">
        <x-form.validation.error name="no_hp" />
    </div>


    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="role" class="form-label">Logo</label>
                <input type="file" class="form-control" wire:model.live="image" accept=".jpg,.png,.jpeg,.gif,.svg">
                <label class="custom-file-label" for="image">
                    @if ($logo && $image == null)
                        <img class="img-thumbnail col-sm-3 d-block mb-1" width="100px"
                            src="{{ asset('storage/' . $logo->path) }}">
                    @endif
                    {!! $image == null
                        ? ''
                        : '<img class="img-thumbnail col-sm-3 d-block mb-1" width="100px" src="' . $image->temporaryUrl() . '" ?>' !!}
                </label>
                <x-form.validation.error name="image" />
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="size" class="form-label">Ukuran Logo</label>
                <input type="number" class="form-control" name="size" id="size" wire:model.live="size">
                <x-form.validation.error name="size" />
            </div>
        </div>
    </div>
    <span wire:click="update()" class="btn btn-primary" wire:target="update" wire:loading.class="disabled">
        <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
        <span wire:loading wire:target="update">Simpan Perubahan...</span>
    </span>



    <!-- Modals add menu -->
    <div id="modal-alert" class="modal fade" tabindex="-1" wire:ignore.self aria-labelledby="modal-alert"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-alert">Berhasil Memperbarui Data Aplikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="empty()"> </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Pembaruan telah disimpan !</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('setting.index') }}" class="btn btn-success">OKE
                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('show-alert', function(e) {
            $('#modal-alert').modal('show');
        })
    </script>
@endpush
