<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0; padding:0; font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; color: #333;">
    <div
        style="max-width: 600px; margin: auto; padding: 32px; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;">
        <div class="text-center mb-6">
            <img src="https://jkibukitzion.my.id/pics/logo_text.png" alt="Logo JKI Bukit Zion"
                style="width: 360px; margin: auto;">
        </div>

        <h2 class="text-xl font-bold text-[#215773] mb-4">Reset Password Anda</h2>

        <p class="mb-4">Halo,</p>

        <p class="mb-4">
            Kami menerima permintaan untuk mereset password akun Anda. Silakan klik tombol di bawah untuk melanjutkan
            proses reset password:
        </p>

        <div style="text-align: center; margin: 32px 0;">
            <a href="{{ $resetLink }}"
                style="
                background-color: #215773;
                color: #ffffff;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 6px;
                display: inline-block;
                font-weight: bold;
            ">Reset
                Password</a>
        </div>

        <p class="mb-4">
            Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini.
        </p>

        <p class="mt-6">Terima kasih,<br><strong>Tim JKI Bukit Zion</strong></p>
    </div>
</body>

</html>
