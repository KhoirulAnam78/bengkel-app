<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="different types of invoice/bill/tally designed with friendly and markup using modern technology, you can use it on any type of website invoice, fully responsive and w3 validated.">
    <meta name="keywords"
        content="bill , receipt, tally, invoice, cash memo, invoice html, invoice pdf, invoice print, invoice templates, multipurpose invoice, template, booking invoice, general invoice, clean invoice, catalog, estimate, proposal">
    <meta name="author" content="initTheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi-{{ $transaksi->no_transaksi }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-ijm.png') }}">
    <style>
        @media print {
            @page {
                size: 80mm 110mm;
                margin: 0mm;
            }

            *,
            *: before,
            *: after {
                box - sizing: border - box;
            }
        }
    </style>
    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets-receipt') }}/css/main-style.css">
</head>

<body class="section-bg-one" style="margin-top:0px;padding-top:3px">

    <main class="container receipt-wrapper" id="download-section" style="margin-top:0px;padding-top:3px">
        <div class="receipt-top" style="font-size: 12px !important">
            <div class="company-name">{{ $app_name }}</div>
            <div class="company-address">Alamat : {{ $alamat }}</div>
            <div class="company-mobile">Kontak : {{ $no_hp }}</div>
        </div>
        <div class="receipt-body">
            <div class="receipt-heading"><span>Transaksi</span></div>
            <div class="text-list text-style1">
                <span class="text-list-title" style="font-size:12px !important">Tanggal :
                    {{ $transaksi->tgl_transaksi }}
                    <br>
                    {{ $transaksi->jenis_transaksi == 'keluar' ? 'Pelanggan :' : 'Supplier :' }}
                    {{ $transaksi->nama_pelanggan ?? '-' }} <br> Keterangan : {{ $transaksi->keterangan ?? '-' }} <br>
                    No
                    Transaksi :
                    {{ $transaksi->no_transaksi }}</span>
            </div>
            <table class="receipt-table" style="font-size:12px !important">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailTrans as $t)
                        <tr>
                            <td>{{ $t->name }}</td>
                            <td>{{ $t->harga }}</td>
                            <td>{{ $t->jumlah }}</td>
                            <td>Rp.{{ $t->sub_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-bill-list mb-15" style="font-size:12px !important">
                <div class="text-bill-list-in">
                    <div class="text-bill-title">Total Harga:</div>
                    <div class="text-bill-value">Rp.{{ $transaksi->total }}</div>
                </div>
                @if ($transaksi->jenis_transaksi == 'keluar')
                    <div class="text-bill-list-in">
                        <div class="text-bill-title">Total Bayar: </div>
                        <div class="text-bill-value">Rp.{{ $transaksi->bayar }}</div>
                    </div>
                    <div class="text-receipt-seperator"></div>
                    <div class="text-bill-list-in">
                        <div class="text-bill-title">Kembalian:</div>
                        <div class="text-bill-value">Rp.{{ $transaksi->kembalian }}</div>
                    </div>
                @endif
            </div>


            @if ($transaksi->jenis_transaksi == 'keluar')
                <div class="mb-10">
                    <h4 class="mb-2 text-title font-700 text-border" style="font-size: 14px"> Terimakasih </h4>
                    {{-- <p>Jangan lupa kembali lagi.</p> --}}
                </div>
            @endif
            {{-- <!-- Return Policy -->
        
            

            <!-- Recycle Offer -->
            <div class="mb-0">
                <h4 class="mb-2 text-title font-700 text-border"> Recycle Offer </h4>
                <p>Recycle shopping bag & get cash for each bag and discount on your purchase </p>
            </div> --}}
        </div>
    </main>

    <script>
        window.print();
    </script>

    <!-- jquery-->
    <script src="{{ asset('assets-receipt') }}/js/jquery-3.7.0.min.js"></script>
    <!-- Plugin -->
    <script src="{{ asset('assets-receipt') }}/js/plugin.js"></script>
    <!-- Main js-->
    <script src="{{ asset('assets-receipt') }}/js/mian.js"></script>
</body>

</html>
