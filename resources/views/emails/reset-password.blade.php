<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <h1>Reset Password</h1>
    <p>Halo,</p>
    <p>Silakan klik tautan berikut untuk mereset password Anda:</p>
    <p><a href="{{ $resetPasswordUrl }}">Reset Password</a></p>
    <p>Jika Anda tidak meminta reset password, harap abaikan email ini.</p>
    <p>Terima kasih,</p>
    <p>{{ $web->website_name }}</p>
</body>

</html>