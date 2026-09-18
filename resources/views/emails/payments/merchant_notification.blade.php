<!DOCTYPE html>
<html>
<head>
    <title>Inflow Notification</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; padding: 40px 20px; margin: 0;">
    <div style="max-width: 550px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid #D20103;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" style="height: 40px; margin-bottom: 20px;">
            <h2 style="color: #1e293b; margin: 0; font-size: 24px;">Payment Received!</h2>
            <p style="color: #10b981; margin-top: 5px; font-size: 15px; font-weight: bold;">₦{{ number_format($transaction->amount, 2) }} Inflow</p>
        </div>

        <p style="color: #334155; font-size: 16px;">Hello <strong style="color: #0f172a;">{{ $merchantName }}</strong>,</p>
        <p style="color: #334155; font-size: 16px; line-height: 1.5;">You have just received a new payment on your Corporate Gateway.</p>
        
        <div style="background-color: #f8fafc; border-radius: 8px; padding: 25px; margin-top: 25px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Customer Email:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-size: 14px;">{{ $transaction->customer_email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Reference:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-size: 14px;">{{ $transaction->session_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Fee Charged:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #D20103; font-size: 14px; font-weight: bold;">₦{{ number_format($transaction->fee_charged, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #64748b; font-size: 14px;"><strong>Date:</strong></td>
                    <td style="padding: 12px 0; text-align: right; color: #0f172a; font-size: 14px;">{{ \Carbon\Carbon::parse($transaction->updated_at)->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
        
        <div style="margin-top: 40px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <p style="font-size: 13px; color: #64748b; margin: 0;">Log in to your dashboard to view your updated settlement balance.</p>
            <p style="font-size: 12px; color: #cbd5e1; margin-top: 15px;">
                Secured by Q4I Payment Gateway &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
