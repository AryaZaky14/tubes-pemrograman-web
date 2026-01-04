<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 12px;
            line-height: 1.6;
        }

        table {
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;
        }

        hr {
            margin: 10px 0;
        }

        p {
            margin: 6px 0;
        }

        .btn-area {
            margin-top: 20px;
            text-align: center;
        }

        .btn {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #28a745;
            color: white;
        }

        @media print {
            .btn-area {
                display: none;
            }
        }
    </style>


    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>

<body>

    <div align="center">

        <h3 style="margin-bottom:5px;">Toko Arya</h3>
        <p style="margin-top:0;">Permata Biru, Bandung</p>

        <hr width="300">

        <p>
            #{{ $trx->nomor }} <br>
            {{ \Carbon\Carbon::parse($trx->tanggal_waktu)->format('d-m-Y H:i:s') }} <br>
            Kasir: {{ $trx->nama }}
        </p>

        <table width="300">
            @foreach ($detail as $d)
                <tr>
                    <td width="120">{{ $d->nama }}</td>
                    <td width="30" align="center">{{ $d->qty }}</td>
                    <td width="70" align="right">{{ number_format($d->harga) }}</td>
                    <td width="80" align="right">{{ number_format($d->total) }}</td>
                </tr>
            @endforeach
        </table>

        <hr width="300">

        <table width="300">
            <tr>
                <td>Total</td>
                <td align="right">{{ number_format($trx->total) }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td align="right">{{ number_format($trx->bayar) }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td align="right">{{ number_format($trx->kembali) }}</td>
            </tr>
        </table>

        <p style="margin-top:10px;">Terima kasih telah berbelanja</p>

        <div class="btn-area">
            <a href="{{ route('kasir.index') }}">
                <button class="btn btn-primary">⬅ Kembali ke Kasir</button>
            </a>

            <button onclick="window.print()" class="btn btn-secondary">
                🖨 Cetak Ulang
            </button>
        </div>

    </div>


</body>

</html>
