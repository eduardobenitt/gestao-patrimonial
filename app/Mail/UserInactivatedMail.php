<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInactivatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $patrimonios;

    public function __construct($user, array $patrimonios)
    {
        $this->user = $user;
        $this->patrimonios = $patrimonios;
    }

    public function build()
    {
        return $this
            ->subject('Notificação de Inativação de Usuário')
            ->text('emails.user.inactivated'); // template text/plain
    }
}
