@extends('layouts.dashboard.app')

@section('title', $title)

@section('breadcrumb')
    <x-dashboard.breadcrumb title="{{ $title }}" page="Transaksi" active="{{ $title }}"
        route="{{ route('transaksi.riwayat') }}" />
@endsection

@push('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @livewireStyles
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0 fw-bold">Riwayat Transaksi Bengkel</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#example').DataTable({
            // ordering: true,
            processing: true,
            serverSide: true,

            ajax: "{{ route('transaksi.riwayat') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'tgl_transaksi',
                    name: 'tgl_transaksi'
                },
                {
                    data: 'no_transaksi',
                    name: 'no_transaksi'
                },
                {
                    data: 'nama_pelanggan',
                    name: 'nama_pelanggan'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
    @livewireScripts
@endpush
