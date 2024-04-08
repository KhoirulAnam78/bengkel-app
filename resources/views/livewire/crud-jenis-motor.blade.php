<div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-form-add">
        <i class="ri-add-line"></i>
        Tambah Jenis Motor
    </button>
    <div class="div mt-3" wire:ignore>
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped align-middle" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Motor</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('livewire.modals.modal-jenis-motor')
</div>

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        document.addEventListener('close-modal', function(e) {
            $('#modal-form-add').modal('hide');
            Swal.fire({
                title: e.detail[0].info,
                text: e.detail[0].message,
                icon: "success",
            });
        });

        document.addEventListener('show-modal-edit', function(e) {
            $('#modal-form-edit').modal('show');
        });
        document.addEventListener('close-modal-edit', function(e) {
            $('#modal-form-edit').modal('hide');
            Swal.fire({
                title: e.detail[0].info,
                text: e.detail[0].message,
                icon: "success",
            });
        });

        document.addEventListener('show-delete-modal', function(e) {
            $('#modal-form-delete').modal('show');
        });
        document.addEventListener('close-delete-modal', function(e) {
            $('#modal-form-delete').modal('hide');
            Swal.fire({
                title: e.detail[0].info,
                text: e.detail[0].message,
                icon: "success",
            });
        });
    </script>

    <script>
        // inititalize table
        $('#example').DataTable({
            // ordering: true,
            processing: true,
            serverSide: true,

            ajax: "{{ route('jenis-motor.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'descriptions',
                    name: 'descriptions'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        //reinit table
        document.addEventListener('update-datatable', function(event) {

            console.log(event);
            $('#example').DataTable().destroy();
            // inititalize table
            $('#example').DataTable({
                // ordering: true,
                processing: true,
                serverSide: true,

                ajax: "{{ route('jenis-motor.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'descriptions',
                        name: 'descriptions'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
