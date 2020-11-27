<?php

namespace App\Notifications;

use App\Providers\RouteServiceProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * Class PasswordResetRequest
 *
 * @author lacal
 */
class PasswordResetRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(RouteServiceProvider::PASSWORD_RESET . '/' . $this->token);
        return (new MailMessage)
            ->subject(Lang::get('Zmena hesla'))
            ->line('Prišla nám požiadavka na zmenu hesla na vašom účte.')
            ->action('Zmena hesla', url($url))
            ->line('Ak ste nepožadovali zmenu hesla prosím okamžite kontaktujte administrátora.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
