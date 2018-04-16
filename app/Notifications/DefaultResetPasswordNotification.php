<?php

namespace CodeFlix\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultResetPasswordNotification extends ResetPassword
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Redefinição de Senha')
            ->line('Você está recebendo este e-mail porque nós recebemos um pedido de redefinição de senha da sua conta.')
            ->action('Redefinir Senha', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Se você não pediu uma redefinição de senha, nenhuma ação futura é necessária.');
    }


}
