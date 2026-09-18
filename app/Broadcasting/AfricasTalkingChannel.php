<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;

class AfricasTalkingChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // The notifiable object should have a method to get the phone number
        $to = $notifiable->routeNotificationFor('africas_talking');
        
        if (empty($to)) {
            // Fallback to checking for phone/phone_number column
            if (isset($notifiable->phone)) {
                $to = $notifiable->phone;
            } elseif (isset($notifiable->phone_number)) {
                $to = $notifiable->phone_number;
            } else {
                return;
            }
        }

        // Get the message content from the notification class
        $message = $notification->toAfricasTalking($notifiable);

        if (empty($message)) {
            return;
        }

        // Initialize Africa's Talking SDK
        $username = env('AFRICASTALKING_USERNAME', ''); // use '' for development in the test environment
        $apiKey   = env('AFRICASTALKING_API_KEY');

        if (empty($apiKey)) {
            Log::warning("Africa's Talking API key is missing. Could not send SMS to {$to}");
            return;
        }

        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();

        try {
            // Ensure phone number starts with + and country code
            if (strpos($to, '+') !== 0) {
                // If it starts with 0 (e.g. Nigerian 080...), remove 0 and add +234
                if (strpos($to, '0') === 0) {
                    $to = '+234' . substr($to, 1);
                } else {
                    $to = '+' . $to;
                }
            }

            $result = $sms->send([
                'to'      => $to,
                'message' => $message,
                // 'from' => 'YourSenderID' // Uncomment and configure if you have a custom alphanumeric sender ID
            ]);
            
            Log::info("SMS sent to {$to} via Africa's Talking", ['result' => $result]);
        } catch (\Exception $e) {
            Log::error("Failed to send Africa's Talking SMS: " . $e->getMessage());
        }
    }
}
