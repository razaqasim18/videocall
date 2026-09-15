@extends('layouts.email')

@section('title', "Reset Your $role Password")
@section('subtitle', 'Secure Account Recovery')

@section('content')
    <div
        style="background-color:#ffffff; border:1px solid #e5e7eb; border-radius:20px; padding:40px 20px; margin-bottom:32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">

        <!-- Badge -->
        <div style="text-align:center; margin-bottom:24px;">
            <span
                style="display:inline-block; padding:6px 12px; border-radius:50px; background-color:#eef2ff; color:#4f46e5; font-size:11px; letter-spacing:0.1em; text-transform:uppercase; font-weight:800; border: 1px solid #c7d2fe;">
                🛡️ {{ $role }} Security
            </span>
        </div>

        <!-- Main Heading -->
        <div style="text-align:center; padding-bottom:20px;">
            <h1 style="margin:0 0 16px; font-size:26px; line-height:1.3; color:#111827; font-weight:800;">
                Password Reset Request
            </h1>
            <p style="margin:0 auto; max-width:400px; font-size:16px; line-height:1.6; color:#4b5563;">
                We received a request to reset the password for your administrator account. No need to worry, it happens to
                the best of us!
            </p>
        </div>

        <!-- Action Button -->
        <div style="text-align:center; padding:32px 0;">
            <a href="{{ $url }}"
                style="display:inline-block; padding:16px 32px; border-radius:12px; background:linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color:#ffffff; text-decoration:none; font-weight:600; font-size:16px; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);">
                Reset My Password
            </a>
        </div>

        <!-- Warning Text -->
        <div style="text-align:center; border-top:1px solid #f3f4f6; padding-top:24px;">
            <p style="margin:0; font-size:14px; line-height:1.6; color:#6b7280;">
                <strong>Didn't request this?</strong><br>
                If you didn't ask to reset your password, you can safely ignore this email. Your password will remain
                unchanged.
            </p>
        </div>
    </div>
@endsection

@section('tip')
    <div
        style="margin-top:32px; padding:24px; background-color:#fdf2f2; border-radius:16px; border:1px solid #fee2e2; text-align:left;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="30" valign="top" style="font-size:20px;">💡</td>
                <td>
                    <p style="margin:0; font-size:14px; line-height:1.5; color:#991b1b;">
                        <strong style="color:#b91c1c;">Security Reminder:</strong>
                        Our team will never ask for your password via email. Always ensure you are on the official admin
                        dashboard before entering your credentials.
                    </p>
                </td>
            </tr>
        </table>
    </div>
@endsection
