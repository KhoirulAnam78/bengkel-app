<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('receipt/style.css') }}">
    <title>Transaksi-{{ $transaksi->no_transaksi }}</title>
</head>

<body>
    <div class="ticket">
        <p class="centered">{{ $app_name }}
            <br>Alamat : {{ $alamat }}
            <br>Kontak : {{ $no_hp }}
        </p>
        <span style="font-size:10px !important">Tanggal :
            {{ $transaksi->tgl_transaksi }}
            <br>
            {{ $transaksi->jenis_transaksi == 'keluar' ? 'Pelanggan :' : 'Supplier :' }}
            {{ $transaksi->nama_pelanggan ?? '-' }} <br> Keterangan : {{ $transaksi->keterangan ?? '-' }} <br>
            No
            Transaksi :
            {{ $transaksi->no_transaksi }}
        </span>
        <table>
            <thead>
                <tr>
                    <th style="font-size:10px !important">Nama</th>
                    <th style="font-size:10px !important">Harga</th>
                    <th style="font-size:10px !important">Jumlah</th>
                    <th style="font-size:10px !important">Subtotal</th>
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
                    <td>Total Harga :</td>
                    <td>Rp.{{ $transaksi->total }}</td>
                </tr>
                <tr>
                    <td>Total Bayar : </td>
                    <td>Rp.{{ $transaksi->bayar }}</td>
                </tr>
                <tr>
                    <td>Kembalian :</td>
                    <td>Rp.{{ $transaksi->kembalian }}</td>
                </tr>
            </table>
        @endif
        @if ($transaksi->jenis_transaksi == 'keluar')
            <div>
                <h4 style="font-size: 14px"> Terimakasih </h4>
                {{-- <p>Jangan lupa kembali lagi.</p> --}}
            </div>
        @endif
    </div>
    <script>
        window.print();
    </script>
    <script src="{{ asset('receipt/script.js') }}"></script>
</body>

</html>
