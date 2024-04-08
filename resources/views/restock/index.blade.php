@extends('layouts.dashboard.app')

@section('title', $title)

@section('breadcrumb')
    <x-dashboard.breadcrumb title="{{ $title }}" page="Restock" active="{{ $title }}"
        route="{{ route('restock.index') }}" />
@endsection

@push('css')
    @livewireStyles
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0 fw-bold">Restock Sparepart</h4>
        </div>
        <div class="card-body">
            <livewire:restock-barang />
        </div>
    </div>
@endsection

@push('script')
    @livewireScripts
@endpush
