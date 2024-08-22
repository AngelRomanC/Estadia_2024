<?php

namespace App\Listeners;

use App\Notifications\RecursamientoNotification2;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User; //agregar usuarios
use Illuminate\Support\Facades\Notification;// agregar




class RecursamientoListener2
{
    
    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        $tutor = $event->recursamientoAdmin->recursamiento->profesor->user;

        // Verificando si el tutor existe y tiene el rol correcto
        if ($tutor && in_array($tutor->role, ['Admin', 'Tutor'])) {
            // Enviando la notificación solo al tutor
            Notification::send($tutor, new RecursamientoNotification2($event->recursamientoAdmin));
        }
        // Enviando la notificación al administrador
        $admin = User::where('role', 'Admin')->first();
        if ($admin) {
            Notification::send($admin, new RecursamientoNotification2($event->recursamientoAdmin));
        }
        User::whereIn('role', [ 'Admin','Tutor'])   
        ->get()
        ->each(function (User $user) use ($event) {        
        Notification::send($user, new RecursamientoNotification2($event->recursamientoAdmin));
    });

 
    }
}
