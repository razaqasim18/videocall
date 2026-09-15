@extends('layouts.email')

@section('title', 'Welcome to ' . config('app.name'))
@section('subtitle', "We're thrilled to have you join our growing community!")

@section('content')
    <!-- Welcome Hero Section -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding-bottom: 30px;">
                <div style="font-size: 60px; line-height: 60px; margin-bottom: 20px;">👋</div>
                <h2
                    style="margin: 0 0 16px 0; font-size: 26px; font-weight: 800; color: var(--color-dark); line-height: 1.3;">
                    Welcome to the community,<br>
                    <span class="text-primary">{{ $user->name }}!</span>
                </h2>
                <p style="margin: 0; font-size: 16px; line-height: 1.6; color: var(--color-gray); max-width: 480px;">
                    Your account has been successfully created. You are now ready to explore everything
                    <strong style="color: var(--color-dark);">{{ $appName }}</strong> has to offer.
                </p>
            </td>
        </tr>
    </table>

    <!-- App Download Section -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
        style="background-color: #f8fafc; border: 1px solid var(--color-border); border-radius: 20px; padding: 32px 20px;">
        <tr>
            <td align="center">
                <p
                    style="margin: 0 0 24px 0; font-size: 14px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">
                    Download our mobile app
                </p>

                <!-- Store Buttons Table -->
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- Apple App Store -->
                        <td style="padding: 0 10px;">
                            <a href="{{ $iosLink }}"
                                style="display: inline-block; padding: 12px 24px; background-color: #000000; color: #ffffff; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 14px;">
                                App Store
                            </a>
                        </td>
                        <!-- Google Play Store (Using CSS Variable via style) -->
                        <td style="padding: 0 10px;">
                            <a href="{{ $androidLink }}"
                                style="display: inline-block; padding: 12px 24px; background-color: var(--color-primary); color: #ffffff; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 14px;">
                                Google Play
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
