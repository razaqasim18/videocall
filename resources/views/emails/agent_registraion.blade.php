@extends('layouts.email')

@section('title', 'Welcome to the Team!')
@section('subtitle', "We're excited to have you on board. Your agent account has been successfully created.")

@section('content')
    <!-- Credentials Card -->
    <div style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;margin-bottom:32px;">
        <div style="margin-bottom:16px;">
            <label
                style="display:block;font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:4px;">Email
                Address</label>
            <div style="font-family:'Courier New', Courier, monospace;font-size:16px;font-weight:700;color:#1e293b;">
                {{ $email }}
            </div>
        </div>
        <div style="border-top:1px solid #e2e8f0;padding-top:16px;">
            <label
                style="display:block;font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:4px;">Temporary
                Password</label>
            <div style="font-family:'Courier New', Courier, monospace;font-size:16px;font-weight:700;color:#1e293b;">
                {{ $password }}
            </div>
        </div>
    </div>
@endsection

@section('tip')
    <div
        style="margin-top:40px;padding:20px;background-color:#fffbeb;border-radius:12px;border:1px solid #fef3c7;text-align:center;">
        <p style="margin:0;font-size:14px;line-height:1.5;color:#92400e;">
            <strong>Security Tip:</strong> For your protection, please change your password immediately after your first
            login.
        </p>
    </div>
@endsection
