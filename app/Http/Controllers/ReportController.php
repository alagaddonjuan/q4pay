<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function exportTransactionsCsv(Request $request)
    {
        // 1. Authenticate the Merchant Programmatically
        $apiKey = $request->header('X-Q4I-API-Key');
        $merchant = Merchant::where('q4i_api_key', $apiKey)->where('is_active', true)->first();

        if (!$merchant) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        // 2. Set the CSV Headers instantly
        $csvFileName = 'q4i_statement_' . strtoupper(str_replace(' ', '_', $merchant->business_name)) . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$csvFileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // 3. Build the CSV rows dynamically inside the Stream Callback
        $callback = function() use ($merchant, $request) {
            $file = fopen('php://output', 'w');
            
            // Write the Header Row
            fputcsv($file, [
                'Date & Time', 
                'Transaction ID', 
                'Session Reference', 
                'Account Number', 
                'Type (Credit/Debit)', 
                'Gross Amount (NGN)', 
                'Q4I Fee (NGN)', 
                'Net Settled Amount (NGN)', 
                'Status', 
                'Remarks'
            ]);

            // Set up the Base Query
            $query = Transaction::with('virtualAccount')
                ->where('merchant_id', $merchant->id)
                ->orderBy('created_at', 'desc');

            // Apply independent date filters
            if ($request->has('start_date')) {
                $query->whereDate('created_at', '>=', $request->input('start_date'));
            }
            if ($request->has('end_date')) {
                $query->whereDate('created_at', '<=', $request->input('end_date'));
            }

            // 🟢 USE CURSOR: Reads 1 row into RAM at a time, preventing server crashes
            foreach ($query->cursor() as $txn) {
                fputcsv($file, [
                    $txn->created_at->format('Y-m-d H:i:s'),
                    $txn->id,
                    $txn->session_id,
                    $txn->virtualAccount ? $txn->virtualAccount->account_number : 'N/A',
                    strtoupper($txn->type),
                    $txn->amount,
                    $txn->fee_charged,
                    $txn->settled_amount ?? $txn->amount, // Fallback if settled_amount is null
                    strtoupper($txn->status),
                    $txn->remarks
                ]);
            }
            
            fclose($file);
        };

        // 4. Stream the download to the client safely
        return response()->stream($callback, 200, $headers);
    }
}