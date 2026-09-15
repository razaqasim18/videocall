<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* Define CSS Variables */
        :root {
            --color-primary: #5b5af7;
            --color-secondary: #8a7bff;
            --color-success: #12b76a;
            --color-error: #e11d48;
            --color-warning: #ff8f47;
            --color-gold: #ffd700;
            --color-dark: #0f172a;
            --color-gray: #64748b;
            --color-border: #e2e8f0;
            --color-bg: #f1f5f9;
            --color-white: #ffffff;
        }

        /* Base Styles */
        body {
            margin: 0;
            padding: 0;
            background-color: var(--color-bg);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        .email-container {
            width: 600px;
            background-color: var(--color-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--color-border);
        }

        .content-padding {
            padding: 48px 40px;
        }

        /* Typography Classes */
        .title-main {
            margin: 0 0 16px 0;
            font-size: 28px;
            font-weight: 800;
            color: var(--color-dark);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .subtitle-main {
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
            color: var(--color-gray);
        }

        /* Utility Classes */
        .text-primary {
            color: var(--color-primary) !important;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .badge-primary {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            background-color: #eef2ff;
            color: var(--color-primary);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        .footer-text {
            font-size: 14px;
            color: var(--color-gray);
            line-height: 1.5;
            margin: 0 0 12px 0;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                border-radius: 0 !important;
                border: none !important;
            }

            .content-padding {
                padding: 24px 20px !important;
            }

            .mobile-center {
                text-align: center !important;
            }
        }
    </style>
</head>

<body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0"
        style="background-color: var(--color-bg); padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Card Container -->
                <table class="email-container" width="600" border="0" cellspacing="0" cellpadding="0">

                    <!-- Top Gradient Accent Bar -->
                    <tr>
                        <td
                            style="background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary) 100%); height: 6px; line-height: 6px; font-size: 6px;">
                            &nbsp;
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="content-padding">
                            <!-- Header Section -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 32px;">
                                        @if (isset($badge))
                                            <span class="badge-primary">{{ $badge }}</span>
                                        @endif
                                        <h1 class="title-main">@yield('title')</h1>
                                        <p class="subtitle-main">@yield('subtitle')</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Dynamic Content Area -->
                            <div style="margin-bottom: 32px;">
                                @yield('content')
                            </div>

                            @yield('tip')
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td
                            style="background-color: #f8fafc; padding: 32px 40px; border-top: 1px solid var(--color-border); text-align: center;">
                            <p class="footer-text">
                                Need help? Contact your administrator or reply to this email.
                            </p>
                            <div style="font-size: 12px; color: #94a3b8; line-height: 1.6;">
                                &copy; {{ date('Y') }} <strong
                                    style="color: #475569;">{{ config('app.name') }}</strong>.
                                All rights reserved.<br>
                                <span style="margin-top: 4px; display: block;">
                                    Designed and Developed by
                                    <a href="{{ config('app.created_by_link') }}" class="text-primary"
                                        style="text-decoration: none; font-weight: 600;">
                                        {{ config('app.created_by') }}
                                    </a>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
