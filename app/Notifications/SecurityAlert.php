<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Broadcasting\AfricasTalkingChannel;

class SecurityAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $message;
    public $type; // 'login', 'inflow', 'outflow', etc.

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $type)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $preferences = is_string($notifiable->notification_preferences) 
                        ? json_decode($notifiable->notification_preferences, true) 
                        : $notifiable->notification_preferences;

        $channels = ['database']; // Default to dashboard

        if ($preferences) {
            if (isset($preferences['channel_email']) && $preferences['channel_email']) {
                $channels[] = 'mail';
            }
            if (isset($preferences['channel_sms']) && $preferences['channel_sms']) {
                $channels[] = AfricasTalkingChannel::class;
            }
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->title)
                    ->line($this->message)
                    ->line('If this was not you, please contact support immediately.')
                    ->action('Go to Dashboard', url('/'));
    }

    /**
     * Get the SMS representation for Africa's Talking.
     */
    public function toAfricasTalking($notifiable)
    {
        return "Q4I Security Alert: {$this->message}";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
        ];
    }

    private function getIcon()
    {
        switch ($this->type) {
            case 'login': return 'las la-sign-in-alt';
            case 'inflow': return 'las la-arrow-down';
            case 'outflow': return 'las la-arrow-up';
            default: return 'las la-bell';
        }
    }

    private function getColor()
    {
        switch ($this->type) {
            case 'login': return 'text-blue-500 bg-blue-100';
            case 'inflow': return 'text-green-500 bg-green-100';
            case 'outflow': return 'text-red-500 bg-red-100';
            default: return 'text-gray-500 bg-gray-100';
        }
    }
}
