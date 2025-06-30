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
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
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
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pembukuan)->translatedFormat('d F Y') }}</td>
                    <td>Rp. {{ number_format($item->nominal_pembukuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jenis_pembukuan }}</td>
                    <td>{{ $item->deskripsi_pembukuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total">
        <p>TOTAL PEMASUKAN: Rp. {{ number_format($total_pemasukan, 0, ',', '.') }}</p>
        <p>TOTAL PENGELUARAN: Rp. {{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
        <p>TOTAL SIMPANAN: Rp. {{ number_format($total_sisa, 0, ',', '.') }}</p>
    </div>
</body>

</html>
