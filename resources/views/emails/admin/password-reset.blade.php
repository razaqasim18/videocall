<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your admin password</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fb;font-family:Inter,Arial,sans-serif;color:#111827;">
    <div style="max-width:640px;margin:40px auto;padding:32px;background:#ffffff;border-radius:24px;box-shadow:0 18px 50px rgba(15,23,42,0.08);">
        <div style="text-align:center;padding-bottom:24px;">
            <div style="display:inline-block;padding:10px 16px;border-radius:999px;background:linear-gradient(90deg,#4f46e5,#7c3aed);color:white;font-size:12px;letter-spacing:0.2em;text-transform:uppercase;font-weight:700;">Admin Access</div>
            <h1 style="margin:20px 0 10px;font-size:28px;line-height:1.2;color:#111827;">Reset your password</h1>
            <p style="margin:0;font-size:16px;line-height:1.7;color:#4b5563;">A password reset was requested for your admin account. Click the button below to create a new password and continue securely.</p>
        </div>

        <div style="text-align:center;padding:24px 0 8px;">
            <a href="{{ $url }}" style="display:inline-block;padding:14px 28px;border-radius:999px;background:linear-gradient(90deg,#4f46e5,#7c3aed);color:#ffffff;text-decoration:none;font-weight:700;font-size:16px;">Set a new password</a>
        </div>

        <p style="margin-top:24px;font-size:14px;line-height:1.7;color:#6b7280;">If you did not request this, you can safely ignore this email. The reset link will expire shortly.</p>
    </div>
</body>
</html>
