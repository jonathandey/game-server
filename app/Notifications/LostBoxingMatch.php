<?php

namespace App\Notifications;

use App\BoxingMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LostBoxingMatch extends Notification
{
    use Queueable;

    protected $boxingMatch = null;

    protected $playerShare = 0;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(BoxingMatch $boxingMatch, $playerShare)
    {
        $this->boxingMatch = $boxingMatch;

        $this->playerShare = $playerShare;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'challenger_user_id' => $this->boxingMatch->{BoxingMatch::ATTRIBUTE_CHALLENGER_USER_ID},
            'monetary_reward' => $this->playerShare,
            'fought_at' => $this->boxingMatch->updated_at,
        ];
    }
}
