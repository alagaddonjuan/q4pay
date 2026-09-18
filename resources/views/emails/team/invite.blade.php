<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Q4I Gateway Invitation</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 20px;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #003366;
            padding: 30px 20px;
            text-align: center;
        }
        .header img {
            height: 40px;
            width: auto;
        }
        .content {
            padding: 40px;
        }
        h1 {
            color: #003366;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .role-badge {
            display: inline-block;
            background-color: #eff6ff;
            color: #1e40af;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 14px;
        }
        .btn-container {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            background-color: #003366;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2);
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ rtrim(config('app.url'), '/') }}/assets/images/logo-with-text.png" alt="Q4I Logo">
        </div>
        <div class="content">
            <h1>You've been invited!</h1>
            <p>Hi <strong>{{ $member->first_name }}</strong>,</p>
            <p>You have been invited to join the <strong>Q4I Corporate Gateway</strong> platform to help manage the merchant account.</p>
            <p>Your assigned role is: <span class="role-badge">{{ ucfirst($member->role) }}</span></p>
            <p>To accept this invitation and set up your secure account credentials (password and transaction PIN), please click the button below:</p>
            
            <div class="btn-container">
                <a href="{{ route('merchant.team.accept-invite', $member->invite_token) }}" class="btn">Activate My Account</a>
            </div>
            
            <p style="font-size: 14px; color: #64748b; margin-top: 40px; margin-bottom: 0;">
                If you did not expect this invitation, you can safely ignore this email. The link will expire automatically.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Q4I Limited. All rights reserved.<br>
            Secure Corporate Payment Gateway
        </div>
    </div>
</body>
</html>
