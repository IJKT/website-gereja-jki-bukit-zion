<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat Baptisan</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 14pt;
            color: #5d5d5d;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .data-text {
            position: absolute;
        }

        /* --- Posisi Baru untuk Debugging --- */

        /* Nama Jemaat & Baptis */
        #nama-jemaat {
            top: 35%;
            left: 0;
            width: 100%;
            text-align: center;
            font-family: "Times New Roman", serif;
            font-size: 40pt;
            font-weight: 700;
            color: #333;
        }

        #nama-baptis {
            top: 43%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 22pt;
        }

        /* Foto Jemaat dan ID */
        #foto-jemaat-container {
            position: absolute;
            top: 48%;
            left: 6.5%;
            width: 11%;
            height: 23%;
        }

        #foto-jemaat-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        #id-jemaat {
            top: 70.5%;
            left: 5%;
            width: 12.5%;
            text-align: center;
            font-size: 11pt;
            letter-spacing: 2px;
        }

        /* Informasi Kelahiran (Baris 1) */
        #tempat-lahir {
            top: 50%;
            left: 30%;
            font-weight: bold;
        }

        #tanggal-lahir {
            top: 50%;
            left: 58%;
            font-weight: bold;
        }

        /* Informasi Baptisan (Baris 2) */
        #hari-baptis {
            top: 67%;
            left: 48%;
            font-weight: bold;
        }

        #tanggal-baptis {
            top: 67%;
            left: 63%;
            font-weight: bold;
        }

        /* Area Tanda Tangan */
        #pembaptis-nama {
            top: 85%;
            left: 37%;
            width: 18%;
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
        }

        #pemimpin-nama {
            top: 85%;
            left: 71%;
            width: 18%;
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
        }
    </style>
</head>

<body>

    <img src="{{ public_path('pics/Format template Sertifikat Baptisan.png') }}" class="background-image" alt="">

    @if ($foto_base64)
        <div id="foto-jemaat-container">
            <img id="foto-jemaat-img" src="{{ $foto_base64 }}" alt="">
        </div>
        <div id="id-jemaat" class="data-text">{{ $data_baptis->id_jemaat }}</div>
    @endif

    <div id="nama-jemaat" class="data-text">{{ strtoupper($data_baptis->jemaat->nama_jemaat) }}</div>
    <div id="nama-baptis" class="data-text">( {{ strtoupper($nama_baptis) }} )</div>

    <div id="tempat-lahir" class="data-text">{{ $data_baptis->jemaat->tmpt_lahir_jemaat }}</div>
    <div id="tanggal-lahir" class="data-text">
        {{ \Carbon\Carbon::parse($data_baptis->jemaat->tgl_lahir_jemaat)->translatedFormat('d F Y') }}</div>

    <div id="hari-baptis" class="data-text">
        {{ \Carbon\Carbon::parse($detail_baptis->tgl_baptis)->translatedFormat('l') }}
    </div>
    <div id="tanggal-baptis" class="data-text">
        {{ \Carbon\Carbon::parse($detail_baptis->tgl_baptis)->translatedFormat('d F Y') }}</div>

    <div id="pembaptis-nama" class="data-text">{{ $detail_baptis->pembaptis->jemaat->nama_jemaat }}</div>
    <div id="pemimpin-nama" class="data-text">Ps. Ivan S. Tjahja</div>

</body>

</html>
