<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\Merchant;
use App\Jobs\ProcessAiChatJob;
use Illuminate\Support\Str;

class SupportChatController extends Controller
{
    public function index(Request $request)
    {
        $merchant = Merchant::current();

        $tickets = SupportTicket::where('merchant_id', $merchant->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json(['tickets' => $tickets]);
    }

    public function show(Request $request, $reference)
    {
        $merchant = Merchant::current();
        
        $ticket = SupportTicket::where('merchant_id', $merchant->id)
                    ->where('reference', $reference)
                    ->firstOrFail();

        $messages = $ticket->messages()->orderBy('created_at', 'asc')->get();

        return response()->json([
            'ticket' => $ticket,
            'messages' => $messages
        ]);
    }

    public function storeTicket(Request $request)
    {
        $merchant = Merchant::current();
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'reference' => 'TKT-' . strtoupper(Str::random(8)),
            'merchant_id' => $merchant->id,
            'subject' => $request->subject,
            'status' => 'open',
        ]);

        $ticket->messages()->create([
            'sender_type' => 'merchant',
            'message' => $request->message,
        ]);

        // Dispatch AI job
        ProcessAiChatJob::dispatch($ticket);

        return response()->json(['success' => true, 'ticket' => $ticket]);
    }

    public function storeMessage(Request $request, $reference)
    {
        $merchant = Merchant::current();
        
        $ticket = SupportTicket::where('merchant_id', $merchant->id)
                    ->where('reference', $reference)
                    ->firstOrFail();

        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'sender_type' => 'merchant',
            'message' => $request->message,
        ]);

        // If ticket is open (AI mode), process it. If escalated, wait for human.
        if ($ticket->status === 'open') {
            ProcessAiChatJob::dispatch($ticket);
        }

        return response()->json(['success' => true]);
    }
}
