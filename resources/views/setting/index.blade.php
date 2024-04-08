@extends('layouts.dashboard.app')


@section('title', 'Pengaturan')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Pengaturan" page="Pengaturan Aplikasi" active="Setting"
        route="{{ route('setting.index') }}" />
@endsection

@section('content')
    <div class="card card-height-100">
        <!-- cardheader -->
        <div class="card-header border-bottom-dashed align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Setting</h4>
        </div>
        <!-- end cardheader -->
        <div class="card-body">
            <livewire:set-app />
        </div>
    </div>
@endsection
