<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StandartNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $notification_content = [];
    public $notification_via = [];

    /**
     * Create a new notification instance.
     */
    public function __construct($notification_content, $notification_via = ['mail', 'database'])
    {
        $this->notification_content = $notification_content;
        $this->notification_via = $notification_via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->notification_via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $this->notification_content['destinataire'] = $notifiable->name;
        return (new MailMessage)
            ->subject('Notification ' . $this->notification_content['libelle'])
            ->markdown('emails.notifications.standart-mail', $this->notification_content->toArray());
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        $datas = [
            'libelle' => $this->notification_content['libelle'],
            'description' => $this->notification_content['description'],
            'ligne' => $this->notification_content['ligne'],
            'table' => $this->notification_content['table'],
        ];

        if (isset($this->notification_content['user_id'])) {
            $user = User::find($this->notification_content['user_id']);
            $datas['user_name'] = $user->name;
            $datas['user_photo'] = $user->photo;
        } else {
            $datas['user_name'] = 'Yam\'s';
            $datas['user_photo'] = env('APP_URL') . '/images/logo.png';
        }

        if (isset($this->notification_content['yamsmanager_route'])) {
            $datas['yamsmanager_route'] = $this->notification_content['yamsmanager_route'];
        }

        return $datas;
    }
}
