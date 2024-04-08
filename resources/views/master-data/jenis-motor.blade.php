@extends('layouts.dashboard.app')

@section('title', $title)

@section('breadcrumb')
    <x-dashboard.breadcrumb title="{{ $title }}" page="Master Data" active="{{ $title }}"
        route="{{ route('jenis-motor.index') }}" />
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
            <h5 class="card-title mb-0">Data Jenis Motor</h5>
        </div>
        <div class="card-body">
            <livewire:crud-jenis-motor />
        </div>
    </div>
@endsection

@push('script')
    @livewireScripts
@endpush
