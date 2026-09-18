<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $merchant = $request->user();
        
        // 1. Start the query unconditionally
        $query = Transaction::where('merchant_id', $merchant->id);

        // 2. Filter by Transaction Type (Credit or Debit)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 3. Filter by Status (Successful, Pending, Failed)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter by Category (Airtime, Data, Betting, Electricity, Payout)
        if ($request->filled('category')) {
            $query->where('remarks', 'like', '%' . $request->category . '%');
        }

        // 5. Filter by Specific Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);
        $transactions->appends($request->all());

        return view('merchant.ledger.index', compact('transactions'));
    }

    public function submitComplaint(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'category' => 'required|string',
            'message' => 'required|string|max:500'
        ]);

        $merchant = $request->user();

        // Save the complaint directly to the database
        DB::table('complaints')->insert([
            'merchant_id' => $merchant->id,
            'transaction_reference' => $request->reference,
            'category' => $request->category,
            'message' => $request->message,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Your complaint for Ref: ' . $request->reference . ' has been logged. Our support team will review it shortly.');
    }

    public function exportCsv(Request $request)
    {
        $merchant = $request->user();
        
        // 🟢 Start the query
        $query = Transaction::where('merchant_id', $merchant->id);

        // 🟢 Apply the exact same filters from the index view so the CSV matches the screen
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('remarks', 'like', '%' . $request->category . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Fetch the filtered transactions
        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Define the CSV headers
        $filename = "Q4I_Ledger_" . date('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Define the columns
        $columns = ['Date & Time', 'Reference', 'Description', 'Type', 'Amount (NGN)', 'Fee (NGN)', 'Status'];

        // Write to the CSV file securely
        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $txn) {
                fputcsv($file, [
                    $txn->created_at->format('Y-m-d H:i A'),
                    $txn->session_id ?? 'SYS-GEN',
                    $txn->remarks,
                    strtoupper($txn->type),
                    $txn->amount,
                    $txn->fee_charged,
                    strtoupper($txn->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}