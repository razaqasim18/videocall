<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Team</title>
</head>

<body style="margin:0;padding:0;background-color:#f8fafc;font-family:'Inter', Arial, sans-serif;color:#1e293b;">
    <div
        style="max-width:600px;margin:40px auto;padding:0;background:#ffffff;border-radius:24px;box-shadow:0 20px 40px rgba(0,0,0,0.05);overflow:hidden;border:1px solid #e2e8f0;">

        <!-- Top Accent Bar -->
        <div style="height:8px;background:linear-gradient(90deg,#4f46e5,#7c3aed);"></div>

        <div style="padding:40px 32px;">
            <!-- Header -->
            <div style="text-align:center;padding-bottom:32px;">
                <div
                    style="display:inline-block;padding:6px 12px;border-radius:999px;background:#eef2ff;color:#4f46e5;font-size:12px;letter-spacing:0.1em;text-transform:uppercase;font-weight:700;margin-bottom:16px;">
                    Account Activated
                </div>
                <h1
                    style="margin:0 0 12px;font-size:30px;font-weight:800;line-height:1.2;color:#0f172a;letter-spacing:-0.5px;">
                    Welcome to the Team!</h1>
                <p style="margin:0;font-size:16px;line-height:1.6;color:#64748b;">We're excited to have you on board.
                    Your agent account has been successfully created. Below are your secure login credentials.</p>
            </div>

            <!-- Credentials Card -->
            <div
                style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;margin-bottom:32px;">
                <div style="margin-bottom:16px;">
                    <label
                        style="display:block;font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:4px;">Email
                        Address</label>
                    <div
                        style="font-family:'Courier New', Courier, monospace;font-size:16px;font-weight:700;color:#1e293b;">
                        {{ $email }}</div>
                </div>
                <div style="border-top:1px solid #e2e8f0;padding-top:16px;">
                    <label
                        style="display:block;font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:4px;">Temporary
                        Password</label>
                    <div
                        style="font-family:'Courier New', Courier, monospace;font-size:16px;font-weight:700;color:#1e293b;">
                        {{ $password }}</div>
                </div>
            </div>

            <!-- CTA Button -->
            <div style="text-align:center;">
                <a href="{{ redirect()->route('agent.login') }}"
                    style="display:inline-block;padding:16px 32px;border-radius:12px;background:linear-gradient(90deg,#4f46e5,#7c3aed);color:#ffffff;text-decoration:none;font-weight:700;font-size:16px;box-shadow:0 10px 15px -3px rgba(79, 70, 229, 0.4);">
                    Login to Dashboard
                </a>
            </div>

            <!-- Security Tip -->
            <div
                style="margin-top:40px;padding:20px;background-color:#fffbeb;border-radius:12px;border:1px solid #fef3c7;text-align:center;">
                <p style="margin:0;font-size:14px;line-height:1.5;color:#92400e;">
                    <strong>Security Tip:</strong> For your protection, please change your password immediately after
                    your first login.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color:#f1f5f9;padding:24px;text-align:center;border-top:1px solid #e2e8f0;">
            <p style="margin:0;font-size:13px;color:#64748b;">
                Need help? Contact your administrator or reply to this email.
            </p>
            <div style="margin-top:12px;font-size:12px;color:#94a3b8;">
                &copy; {{ date('Y') }} Your Company Name. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
