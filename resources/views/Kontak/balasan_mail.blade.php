<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Balasan Pesan Anda</title>
</head>

<body style="margin:0; padding:0; font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; color: #333;">
    <div
        style="max-width: 600px; margin: auto; padding: 32px; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="https://jkibukitzion.my.id/pics/logo_text.png" alt="Logo JKI Bukit Zion"
                style="width: 300px; margin: auto;">
        </div>

        <h2 style="color: #215773; font-size: 20px; font-weight: bold; margin-bottom: 16px;">Balasan untuk Pesan Anda
        </h2>

        <p style="margin-bottom: 16px;">Shalom,</p>

        <p style="margin-bottom: 16px;">
            Terima kasih telah menghubungi JKI Bukit Zion. Kami telah menerima pesan Anda seperti berikut:
            "{{ $pesan }}"
        </p>

        <div style="background-color: #f5f5f5; padding: 16px; border-left: 4px solid #215773; margin-bottom: 24px;">
            {{ $balasan }}
        </div>

        <p style="margin-bottom: 16px;">
            Apabila terdapat hal lain yang ingin Anda tanyakan atau klarifikasi lebih lanjut, jangan ragu untuk membalas
            email ini atau menghubungi kami melalui kontak resmi yang tersedia.
        </p>

        <p style="margin-top: 32px;">Salam hormat,<br><strong>Tim JKI Bukit Zion</strong></p>
    </div>
</body>

</html>
