@extends('layouts.dashboard.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <x-dashboard.breadcrumb :title="'Dashboard'" :page="'Dashboard'" :active="'Dashboard'" :route="route('dashboard.index')" />
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5>Selamat Datang {{ auth()->user()->username }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card border border-secondary">
                            <div class="card-body">
                                <h5 class="card-title mb-1 text-secondary fw-bold">Jumlah Transaksi Hari Ini </h5>
                                <p class="text-muted mb-0">Jumlah transaksi pelanggan di bengkel hari ini</p>
                                <h3 class="mb-1 text-secondary fw-bold">{{ $transaksi_hari_ini }}</h3>
                                <p class="card-text text-secondary">Total Pemasukan : Rp. {{ $penghasilan }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border border-success">
                            <div class="card-body">
                                <h5 class="card-title mb-1 text-success fw-bold">Jumlah Pengeluaran Hari Ini </h5>
                                <p class="text-muted mb-0">Jumlah transaksi keluar di bengkel hari ini</p>
                                <h3 class="mb-1 text-success fw-bold">{{ $pengeluaran_hari_ini }}</h3>
                                <p class="card-text text-success">Total Pengeluaran : Rp. {{ $pengeluaran }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card border border-warning">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="col-12 mb-5">
                    <div id="chart1" height="500px"></div>
                </div>
                <div class="col-12">
                    <div id="chart2" height="500px"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <script>
        Highcharts.chart('chart1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Transaksi Pelanggan per Bulan ' + {!! json_encode(date('Y')) !!}
            },
            xAxis: {
                categories: {!! json_encode($chartPemasukan['x']) !!},
                crosshair: true,
                accessibility: {
                    description: 'Bulan'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah dan Rupiah'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true, // <-- Enable data labels
                        format: '{y}', // <-- Show value
                        style: {
                            fontWeight: 'bold',
                            color: 'black'
                        }
                    }
                }
            },
            series: [{
                    name: 'Jumlah Transaksi',
                    data: {!! json_encode($chartPemasukan['y']) !!}
                },
                {
                    name: 'Penghasilan',
                    data: {!! json_encode($chartPemasukan['z']) !!}
                }
            ]
        });


        Highcharts.chart('chart2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pengeluaran Belanja Restock per Bulan' + {!! json_encode(date('Y')) !!}
            },
            xAxis: {
                categories: {!! json_encode($chartPengeluaran['x']) !!},
                crosshair: true,
                accessibility: {
                    description: 'Bulan'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah dan Rupiah'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true, // <-- Enable data labels
                        format: '{y}', // <-- Show value
                        style: {
                            fontWeight: 'bold',
                            color: 'black'
                        }
                    }
                }
            },
            series: [{
                    name: 'Jumlah Transaksi',
                    data: {!! json_encode($chartPengeluaran['y']) !!}
                },
                {
                    name: 'Pengeluaran',
                    data: {!! json_encode($chartPengeluaran['z']) !!}
                }
            ]
        });
    </script>
@endpush
