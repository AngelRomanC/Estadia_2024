<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredencialesEstudianteNotification extends Notification
{
    use Queueable;

    protected $email;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $role = $notifiable->role; // Accede al rol del usuario

        // Define un mensaje basado en el rol del usuario
        $message = '';
        if ($role == 'Tutor') {
            $message = 'Bienvenido Tutor, estas son tus credenciales.';
        } elseif ($role == 'Admin') {
            $message = 'Bienvenido Administrador, estas son tus credenciales.';
        } elseif ($role == 'Alumno') {
            $message = 'Bienvenido Alumno, estas son tus credenciales.';
        }

        return (new MailMessage)
                    ->subject('Credenciales de Acceso')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('Se ha creado una cuenta para ti en nuestra plataforma.')
                    ->line($message)
                    ->line('Correo: ' . $this->email)
                    ->line('Contraseña: ' . $this->password)
                    ->line('Por favor, cambia tu contraseña después de iniciar sesión.')
                    ->action('Iniciar sesión', url('/login',false,false))
                    ->line('¡Gracias por usar nuestra plataforma!')
                    ->salutation('Plataforma de Seguimiento del Desempeño Académico');
                    
    }

    public function toArray(object $notifiable): array
    {
        return [
            // Implementación adicional si es necesaria
        ];
    }
}

