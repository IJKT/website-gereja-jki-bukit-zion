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
        <p><strong>Daftar Pengajuan Jemaat Bukit Zion {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</strong></p>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>TANGGAL PENGAJUAN</th>
                <th>NAMA JEMAAT</th>
                <th>JENIS PENGAJUAN</th>
                <th>STATUS PENGAJUAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $item->jemaat->nama_jemaat }}</td>
                    <td>{{ $item->jenis_pengajuan }}</td>
                    <td>
                        @php
                            $statusMap = [
                                0 => 'Menunggu Verifikasi',
                                1 => 'Diverifikasi',
                                2 => 'Ditolak',
                                3 => 'Dicetak',
                                4 => 'Diberikan',
                            ];

                            $status = $statusMap[$item->verifikasi_pengajuan] ?? 'Unknown';
                        @endphp

                        {{ $status }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
