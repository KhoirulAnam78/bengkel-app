<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="{{ asset('receipt/fiddle.css') }}">
    <title>Transaksi-{{ $transaksi->no_transaksi }}</title>
</head>

<body>
    <div class="page">
        <p class="centered" style="font-size:10px !important;">
            <b>{{ $app_name }}</b>
            <br>Alamat : {{ $alamat }}
            <br>Kontak : {{ $no_hp }}
        </p>
        <p style="font-size:10px !important; margin-bottom:5px">Tanggal :
            {{ $transaksi->tgl_transaksi }}
            <br>
            {{ $transaksi->jenis_transaksi == 'keluar' ? 'Pelanggan :' : 'Supplier :' }}
            {{ $transaksi->nama_pelanggan ?? '-' }} <br> Keterangan : {{ $transaksi->keterangan ?? '-' }} <br>
            No
            Transaksi :
            {{ $transaksi->no_transaksi }}
        </p>
        <table>
            <thead>
                <tr>
                    <th style="font-size:10px !important" align="left">Nama</th>
                    <th style="font-size:10px !important" align="left">Harga</th>
                    <th style="font-size:10px !important" align="left">Jumlah</th>
                    <th style="font-size:10px !important" align="left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailTrans as $t)
                    <tr>
                        <td style="font-size:10px !important">{{ $t->name }}</td>
                        <td style="font-size:10px !important">{{ $t->harga }}</td>
                        <td style="font-size:10px !important">{{ $t->jumlah }}</td>
                        <td style="font-size:10px !important">Rp.{{ $t->sub_total }}</td>
                    </tr>
                @endforeach


            </tbody>
        </table>

        @if ($transaksi->jenis_transaksi == 'keluar')
            <table>
                <tr>
                    <td style="font-size:10px !important">Total Harga :</td>
                    <td style="font-size:10px !important">Rp.{{ $transaksi->total }}</td>
                </tr>
                <tr>
                    <td style="font-size:10px !important">Total Bayar : </td>
                    <td style="font-size:10px !important">Rp.{{ $transaksi->bayar }}</td>
                </tr>
                <tr>
                    <td style="font-size:10px !important">Kembalian :</td>
                    <td style="font-size:10px !important">Rp.{{ $transaksi->kembalian }}</td>
                </tr>
            </table>
        @endif
        @if ($transaksi->jenis_transaksi == 'keluar')
            <div>
                <h4 style="font-size: 10px"> Terimakasih </h4>
                {{-- <p>Jangan lupa kembali lagi.</p> --}}
            </div>
        @endif
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
