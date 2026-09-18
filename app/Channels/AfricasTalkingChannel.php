<?php

namespace App\Channels;

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
        if (!method_exists($notification, 'toAfricasTalking')) {
            return;
        }

        $message = $notification->toAfricasTalking($notifiable);
        $to = $notifiable->routeNotificationFor('Sms', $notification) ?? $notifiable->phone;

        if (!$to) {
            return;
        }

        try {
            $username = env('AFRICASTALKING_USERNAME', '');
            $apiKey   = env('AFRICASTALKING_API_KEY');
            
            if (!$apiKey) {
                Log::warning('AfricasTalking API key not configured.');
                return;
            }

            $AT = new AfricasTalking($username, $apiKey);
            $sms = $AT->sms();

            // Format phone number to E.164 if it's local Nigerian
            if (str_starts_with($to, '0')) {
                $to = '+234' . substr($to, 1);
            } elseif (!str_starts_with($to, '+')) {
                $to = '+' . $to;
            }

            $result = $sms->send([
                'to'      => $to,
                'message' => $message,
                // 'from' => env('AFRICASTALKING_SENDER_ID') // optional
            ]);

            Log::info('AfricasTalking SMS sent: ', (array) $result);

        } catch (\Exception $e) {
            Log::error('AfricasTalking Error: ' . $e->getMessage());
        }
    }
}
