<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Jobs\ProcessAgentBulkImport;

class BulkImportController extends Controller
{
    public function uploadAgentsCsv(Request $request)
    {
        $merchant = $request->user();

        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120', // Max 5MB
        ]);

        // ==========================================
        // 1. SECURE STORAGE (Compliance Fix)
        // ==========================================
        // We explicitly use the 'local' disk to ensure this file is strictly 
        // kept behind the server firewall and never exposed to the public web.
        $path = $request->file('file')->store('imports', 'local');

        // Generate a unique Batch ID for tracking
        $batchId = 'BATCH-' . strtoupper(Str::random(10));

        // ==========================================
        // 2. IMPORT TRACKING LEDGER (UX Fix)
        // ==========================================
        // Log this batch so the Merchant Dashboard can track its progress
        DB::table('bulk_imports')->insert([
            'merchant_id' => $merchant->id,
            'batch_id' => $batchId,
            'file_path' => $path,
            'status' => 'processing', 
            'total_rows' => 0, // The Queue worker will count and update this
            'successful_rows' => 0,
            'failed_rows' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Dispatch the Job
        // Pass the primitive ID instead of the full model for a lighter queue payload,
        // along with the specific Batch ID so the worker can update the ledger.
        ProcessAgentBulkImport::dispatch($merchant->id, $path, $batchId);

        return response()->json([
            'status' => 'success',
            'message' => 'Bulk import started securely. You can track the progress on your dashboard.',
            'data' => [
                'batch_id' => $batchId
            ]
        ], 200);
    }
}