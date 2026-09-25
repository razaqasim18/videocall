<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Theme Palette Conversion:
           Primary: #35618e
           Secondary: #9fcafd
           Dark: #191c20
           Surface: #ffffff
           Background: #f8f9ff
        */
        body {
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9ff;
            /* --color-background */
            color: #191c20;
            /* --color-dark */
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            /* --color-surface */
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(25, 28, 32, 0.05);
            border: 1px solid #e2e8f0;
        }

        .header {
            background-color: #35618e;
            /* --color-primary */
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .content {
            padding: 40px;
            text-align: center;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .approved {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #191c20;
            margin-bottom: 16px;
        }

        .description {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
        }

        .credential-box {
            background-color: #f8f9ff;
            /* --color-background */
            border: 1px solid #9fcafd;
            /* --color-secondary */
            border-radius: 16px;
            padding: 24px;
            margin: 30px 0;
            text-align: left;
        }

        .credential-row {
            margin-bottom: 12px;
            font-size: 15px;
            display: block;
        }

        .credential-row:last-child {
            margin-bottom: 0;
        }

        .label {
            font-weight: 600;
            color: #35618e;
            /* --color-primary */
            width: 100px;
            display: inline-block;
        }

        .value {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            color: #191c20;
        }

        .btn {
            display: inline-block;
            padding: 16px 32px;
            background-color: #35618e;
            /* --color-primary */
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(53, 97, 142, 0.3);
        }

        .footer {
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            background-color: #fcfcfc;
            border-top: 1px solid #f1f5f9;
        }

        .footer strong {
            color: #35618e;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset</h1>
        </div>
        <div class="content">
            <p>Hello, <br> You are receiving this email because we received a password reset request for your account.
            </p>

            <a href="{{ $url }}" class="btn">Reset My Password</a>

            <p class="warning">
                This link will expire in {{ $count }} minutes. <br>
                If you did not request a password reset, please ignore this email.
            </p>
        </div>
        <!-- Footer: Cleaned and Professional -->
        <div class="footer"
            style="padding: 30px; text-align: center; font-size: 13px; color: #94a3b8; background-color: #fcfcfc; border-top: 1px solid #f1f5f9;">
            &copy; {{ date('Y') }} <strong style="color: #35618e;">{{ $appName }}</strong>. All rights
            reserved. Designed and Developed by <a style="color: #35618e;"
                href="{{ config('app.created_by_link') }}"><strong>{{ config('app.created_by') }}</strong></a>
        </div>
    </div>
</body>

</html>
