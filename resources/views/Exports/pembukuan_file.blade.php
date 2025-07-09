<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pembukuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2,
        .header h4 {
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
            text-align: center;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
        }

        .print-info {
            position: absolute;
            top: 0px;
            left: 0px;
            font-size: 12px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="header">
        @php
            $path = public_path('pics/logo_pic.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        @endphp
        <img src="{{ $base64 }}" alt="Logo" style="width: 50px;">
        <h2>GEREJA JKI BUKIT ZION</h2>
        <h4>Jl. Manyar Kartika Timur No.2, RW.6, Menur Pumpungan, Kec. Sukolilo, Surabaya, Jawa Timur 60118</h4>
        <p><strong>{{ $label_periode }}</strong></p>

    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>TANGGAL</th>
                <th>NOMINAL</th>
                <th>TIPE</th>
                <th>DESKRIPSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembukuan as $item)
                <tr>
                    <td style="white-space: nowrap; text-align: center;">
                        {{ \Carbon\Carbon::parse($item->tgl_pembukuan)->translatedFormat('d F Y') }}</td>
                    <td style="white-space: nowrap; text-align: right;">
                        {{ number_format($item->nominal_pembukuan, 0, ',', '.') }} IDR</td>
                    <td style="white-space: nowrap;">
                        {{ $item->jenis_pembukuan }}
                        @if ($item->jenis_pembukuan == 'Uang Masuk')
                            - {{ $item->jenis_pemasukan }}
                        @endif
                    </td>
                    <td style="white-space: normal;">{{ $item->deskripsi_pembukuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total">
        <p>TOTAL PEMASUKAN: Rp. {{ number_format($total_pemasukan, 0, ',', '.') }}</p>
        <p>TOTAL PENGELUARAN: Rp. {{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
        <p>TOTAL SALDO: Rp. {{ number_format($total_sisa, 0, ',', '.') }}</p>
    </div>


    <div class="print-info">
        Dicetak oleh: {{ auth()->user()->jemaat->nama_jemaat }} |
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>
</body>

</html>
