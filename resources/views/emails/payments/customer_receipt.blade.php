<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; padding: 40px 20px; margin: 0;">
    <div style="max-width: 550px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid #0052cc;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" style="height: 40px; margin-bottom: 20px;">
            <h2 style="color: #1e293b; margin: 0; font-size: 24px;">Payment Successful</h2>
            <p style="color: #64748b; margin-top: 5px; font-size: 15px;">Here is your transaction receipt</p>
        </div>

        <p style="color: #334155; font-size: 16px;">Hello,</p>
        <p style="color: #334155; font-size: 16px; line-height: 1.5;">Thank you for your payment to <strong style="color: #0f172a;">{{ $merchantName }}</strong>.</p>
        
        <div style="background-color: #f8fafc; border-radius: 8px; padding: 25px; margin-top: 25px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Amount Paid:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-size: 16px; font-weight: bold;">₦{{ number_format($transaction->amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Reference:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-size: 14px;">{{ $transaction->session_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;"><strong>Status:</strong></td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0; text-align: right; color: #10b981; font-size: 14px; font-weight: bold;">Successful</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: #64748b; font-size: 14px;"><strong>Date:</strong></td>
                    <td style="padding: 12px 0; text-align: right; color: #0f172a; font-size: 14px;">{{ \Carbon\Carbon::parse($transaction->updated_at)->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
        
        <div style="margin-top: 40px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <p style="font-size: 12px; color: #94a3b8; margin: 0;">If you have any questions about this receipt, please contact <strong>{{ $merchantName }}</strong>.</p>
            <p style="font-size: 12px; color: #cbd5e1; margin-top: 10px;">
                Secured by Q4I Payment Gateway &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
