<?php

namespace App\Domains\Friend\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Domains\User\Models\User;

class Friendship extends Notification implements ShouldQueue
{
    use Queueable;

    private User $requestUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $requestUser)
    {
        $this->requestUser = $requestUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //        return (new MailMessage)
        //                    ->line('The introduction to the notification.')
        //                    ->action('Notification Action', url('/'))
        //                    ->line('Thank you for using our application!');
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
            'id' => $this->requestUser->id,
            'name' => $this->requestUser->name,
            'email' => $this->requestUser->email
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->requestUser->id,
            'name' => $this->requestUser->name,
            'email' => $this->requestUser->email
        ]);
    }
}
