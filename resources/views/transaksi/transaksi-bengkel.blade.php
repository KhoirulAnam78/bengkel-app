@extends('layouts.dashboard.app')

@section('title', $title)

@section('breadcrumb')
    <x-dashboard.breadcrumb title="{{ $title }}" page="Transaksi" active="{{ $title }}"
        route="{{ route('transaksi.bengkel') }}" />
@endsection

@push('css')
    @livewireStyles
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0 fw-bold">Proses Transaksi</h4>
        </div>
        <div class="card-body">
            <livewire:crud-transaksi-bengkel />
        </div>
    </div>
@endsection

@push('script')
    @livewireScripts
@endpush
