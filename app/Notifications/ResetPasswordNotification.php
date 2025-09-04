<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Support\HtmlString;

class ResetPasswordNotification extends BaseResetPassword
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Solicitação de Redefinição de Senha')
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para a sua conta.')
            ->line(new HtmlString('Login: <strong>' . e($notifiable->login) . '</strong>')) // 👈 negrito
            ->action('Redefinir Senha', $url)
            ->line('Este link de redefinição de senha expirará em 60 minutos.')
            ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.')
            ->salutation('Atenciosamente,')
            ->line('© 2025 ' . config('custom.project_name') . '. Todos os direitos reservados.');
    }
}
