<!DOCTYPE html>

<head>
    <title>Transaksi-{{ $transaksi->no_transaksi }}</title>
    <style>
        @media print {
            body {
                font-size: 10px !important;
                /* Sesuaikan ukuran */
                font-family: "Arial", sans-serif;
                /* Gunakan font yang jelas */
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td,
            th {
                padding: 2px 4px;
            }
        }
    </style>
</head>

<body>
    <div class="page" style="width: 100%">
        <p class="centered" style="font-size:10px !important; ">
            @if ($app_logo)
                {{-- {{ asset('storage/' . $app_logo->path) }} --}}
                {{-- {{ asset('assets/images/logo-ijm.png') }} --}}
                <img src="{{ asset('assets/images/logo-ijm.png') }}" alt="" height="{{ $app_logo->size }}"
                    style="margin:0px;padding:0px">
            @endif
            <br>
            <b style="margin:0px;padding:0px; font-size:14px">{{ $app_name }}</b>
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
                    <th style="font-size:10px !important" align="left">Jml</th>
                    <th style="font-size:10px !important" align="left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailTrans as $t)
                    <tr>
                        <td style="font-size:10px !important">{{ $t->name }}</td>
                        <td style="font-size:10px !important" nowrap>Rp. {{ $t->harga }}</td>
                        <td style="font-size:10px !important">{{ $t->jumlah }}</td>
                        <td style="font-size:10px !important"nowrap>Rp.{{ $t->sub_total }}</td>
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
        <br>
        @if ($transaksi->jenis_transaksi == 'keluar')
            <div>
                <b style="font-size: 10px; text-align: center"> Terimakasih </b>
                {{-- <p>Jangan lupa kembali lagi.</p> --}}
            </div>
        @endif
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
