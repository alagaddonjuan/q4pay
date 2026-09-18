<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessAiChatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if ticket is still open before processing
        if ($this->ticket->status !== 'open') {
            return;
        }

        $messages = $this->ticket->messages()->orderBy('created_at', 'asc')->get();
        
        $lastMessage = $messages->last();
        if ($lastMessage && $lastMessage->sender_type !== 'merchant') {
            // Only respond to merchant messages
            return;
        }

        // Simple mock detection for escalation
        $userText = strtolower($lastMessage->message ?? '');
        if (str_contains($userText, 'human') || str_contains($userText, 'agent') || str_contains($userText, 'real person') || str_contains($userText, 'escalate')) {
            $this->escalateTicket();
            return;
        }

        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            // Mock response if no API key is provided
            $this->mockAiResponse($userText);
            return;
        }

        // Format history for Gemini
        $contents = [];
        foreach ($messages as $msg) {
            $role = ($msg->sender_type === 'merchant') ? 'user' : 'model';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $msg->message]]
            ];
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => "You are PaySupport AI, a helpful, professional support assistant for a Fintech platform named Q4Pay. You help merchants with billing, transactions, and API integration. Keep answers concise. If you cannot solve the problem or the user is frustrated, tell them you will connect them to a human agent, and include the word [ESCALATE] in your response."]
                    ]
                ],
                'contents' => $contents,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "I'm sorry, I couldn't process that.";
                
                if (str_contains($reply, '[ESCALATE]')) {
                    $reply = str_replace('[ESCALATE]', '', $reply);
                    $this->saveAiResponse(trim($reply));
                    $this->escalateTicket();
                } else {
                    $this->saveAiResponse($reply);
                }
            } else {
                Log::error('Gemini API Error', ['response' => $response->body()]);
                $this->saveAiResponse("I'm currently experiencing technical difficulties reaching my AI provider. Please try again later or type 'human' to speak with a human agent.");
            }
        } catch (\Exception $e) {
            Log::error('Gemini API Exception', ['error' => $e->getMessage()]);
            $this->saveAiResponse("I encountered an internal error. Type 'human' to escalate.");
        }
    }

    private function saveAiResponse($message)
    {
        $this->ticket->messages()->create([
            'sender_type' => 'ai',
            'message' => $message,
        ]);
    }

    private function escalateTicket()
    {
        $this->ticket->update([
            'status' => 'escalated',
            'escalated_at' => now(),
        ]);
        
        $this->ticket->messages()->create([
            'sender_type' => 'system',
            'message' => 'This ticket has been escalated to a human support agent. Please wait for an agent to join the chat.',
        ]);
    }

    private function mockAiResponse($userText)
    {
        // Add a slight delay to simulate processing
        sleep(2);
        
        $responses = [
            "Hello! I am PaySupport AI. (Mock Mode). How can I help you with your transactions today?",
            "I've checked our records, but I might need more details. Could you specify the transaction reference?",
            "That's a great question about our APIs! You can find more information in our API documentation section.",
            "I'm sorry to hear that. I can assist you with refunds or technical issues.",
        ];
        
        $this->saveAiResponse($responses[array_rand($responses)]);
    }
}
