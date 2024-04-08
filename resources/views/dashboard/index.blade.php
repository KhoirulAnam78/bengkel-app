@extends('layouts.dashboard.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<x-dashboard.breadcrumb
    :title="'Dashboard'"
    :page="'Dashboard'"
    :active="'Dashboard'"
    :route="route('dashboard.index')"
/>
@endsection

@section('content')
    <h1>Hallo</h1>
    <p>
    @foreach (Auth::user()->roles as $item)
        - {{ $item->name }} <br>
    @endforeach
    </p>
@endsection