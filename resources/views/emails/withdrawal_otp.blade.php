<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Withdrawal Authorization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #003366;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .otp-box {
            background-color: #f9f9f9;
            border: 2px dashed #003366;
            text-align: center;
            padding: 15px;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #003366;
        }
        .footer {
            background-color: #f4f4f4;
            color: #777;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Withdrawal Authorization</h2>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You have initiated a withdrawal request of <strong>&#8358;{{ number_format($amount, 2) }}</strong> from your vault.</p>
            <p>Please use the following One-Time Password (OTP) to authorize this transaction:</p>
            
            <div class="otp-box">
                {{ $otp }}
            </div>
            
            <p>This OTP is valid for the next 15 minutes. <strong>Do not share this code with anyone, including support staff.</strong></p>
            <p>If you did not initiate this withdrawal, please secure your account immediately and contact our support team.</p>
            <br>
            <p>Best Regards,</p>
            <p><strong>The Q4I Security Team</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Q4I Gateway Platform. All rights reserved.
        </div>
    </div>
</body>
</html>
