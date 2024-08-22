<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(['name' => 'Santiago', 'apellido_paterno' => 'Heras', 'apellido_materno' => 'Gomez','numero' => '7775420768', 'email' => 'admin@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Admin']);
        DB::table('users')->insert(['name' => 'Miguel', 'apellido_paterno' => 'roman', 'apellido_materno' => 'Chano','numero' => '7772052238', 'email' => 'RCMO202029@UPEMOR.EDU.MX', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Juan paulo', 'apellido_paterno' => 'Sanchez', 'apellido_materno' => 'Hernandez','numero' => '7772054338', 'email' => 'juanpaulo@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Tutor']);
        DB::table('users')->insert(['name' => 'Deny Lizbeth', 'apellido_paterno' => 'Hernandez', 'apellido_materno' => 'Rabadan','numero' => '7772054338', 'email' => 'deny@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Tutor']);
        DB::table('users')->insert(['name' => 'José Santiago', 'apellido_paterno' => 'Heras', 'apellido_materno' => 'Gómez','numero' => '7775420768', 'email' => 'santiheras09@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);

        $user1 = User::where('email', 'admin@gmail.com')->first();$user1->assignRole('Admin');
        $user2 = User::where('email', 'RCMO202029@UPEMOR.EDU.MX')->first(); $user2->assignRole('Alumno');
        $user3 = User::where('email', 'juanpaulo@gmail.com')->first();$user3->assignRole('Tutor');
        $user4 = User::where('email', 'deny@gmail.com')->first();$user4->assignRole('Tutor');
        $user5 = User::where('email', 'santiheras09@gmail.com')->first();$user5->assignRole('Alumno');

        $perfil = Role::where('name', 'Admin')->first();
        $user = Role::where('name', 'Alumno')->first();
        DB::table('profesors')->insert(['grado_academico' => 'Doctor', 'area' => 'Inteligencia Artificial y Aprendizaje Automático', 'user_id' => '3']);
        DB::table('profesors')->insert(['grado_academico' => 'Doctor', 'area' => 'Inteligencia Artificial y Aprendizaje Automático', 'user_id' => '4']);
        DB::table('alumnos')->insert(['cuatrimestre' => '10', 'matricula' => 'RCMO20032', 'user_id' => '2']);
        DB::table('alumnos')->insert(['cuatrimestre' => '11', 'matricula' => 'HGJO200332', 'user_id' => '5']);
        
        //Alumnos 
        DB::table('users')->insert(['name' => 'Antonio', 'apellido_paterno' => 'Garcia', 'apellido_materno' => 'Martinez','numero' => '77724326238', 'email' => 'antonio@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Jose', 'apellido_paterno' => 'Lopez', 'apellido_materno' => 'Sanchez','numero' => '7772432448', 'email' => 'jose@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Francisco', 'apellido_paterno' => 'Gonzalez', 'apellido_materno' => 'Gomez','numero' => '7772052957', 'email' => 'francisco@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Juan', 'apellido_paterno' => 'Fernandez', 'apellido_materno' => 'Moreno','numero' => '7772978238', 'email' => 'juan@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Manuel', 'apellido_paterno' => 'Jimenez', 'apellido_materno' => 'Perez','numero' => '7772044238', 'email' => 'manuel@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Pedro', 'apellido_paterno' => 'Rodriguez', 'apellido_materno' => 'Navarro','numero' => '7772342238', 'email' => 'pedro@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Jesus', 'apellido_paterno' => 'Ruiz', 'apellido_materno' => 'Diaz','numero' => '7772552238', 'email' => 'jesus@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Angel', 'apellido_paterno' => 'Serrano', 'apellido_materno' => 'Hernandez','numero' => '7772652238', 'email' => 'angel@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Miguel', 'apellido_paterno' => 'Muñoz', 'apellido_materno' => 'Picazo','numero' => '7772123238', 'email' => 'migue@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Javier', 'apellido_paterno' => 'Saez', 'apellido_materno' => 'Ortega','numero' => '7772432138', 'email' => 'javier@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Jose Antonio', 'apellido_paterno' => 'Romero', 'apellido_materno' => 'Morcillo','numero' => '7772998838', 'email' => 'joseantonio@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'David', 'apellido_paterno' => 'Rubio', 'apellido_materno' => 'Cano','numero' => '7772077238', 'email' => 'david@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Carlos', 'apellido_paterno' => 'Alfaro', 'apellido_materno' => 'Ortega','numero' => '7772121238', 'email' => 'carlos@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Jose Luis', 'apellido_paterno' => 'Molina', 'apellido_materno' => 'Morcillo','numero' => '7777566238', 'email' => 'joseluis@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Alejandro', 'apellido_paterno' => 'Lozano', 'apellido_materno' => 'Marin','numero' => '7770022238', 'email' => 'alejandro@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        DB::table('users')->insert(['name' => 'Miguel Angel', 'apellido_paterno' => 'Castillo', 'apellido_materno' => 'Cuenca','numero' => '7772052238', 'email' => 'miguelangel@gmail.com', 'email_verified_at' => '2024-01-17 04:50:32', 'password' => Hash::make('123'), 'role' =>'Alumno']);
        //asignacion de rol
        $user6 = User::where('email', 'antonio@gmail.com')->first(); $user6->assignRole('Alumno');
        $user7 = User::where('email', 'jose@gmail.com')->first(); $user7->assignRole('Alumno');
        $user8 = User::where('email', 'francisco@gmail.com')->first(); $user8->assignRole('Alumno');
        $user9 = User::where('email', 'juan@gmail.com')->first(); $user9->assignRole('Alumno');
        $user10 = User::where('email', 'manuel@gmail.com')->first(); $user10->assignRole('Alumno');
        $user11 = User::where('email', 'pedro@gmail.com')->first(); $user11->assignRole('Alumno');
        $user12 = User::where('email', 'jesus@gmail.com')->first(); $user12->assignRole('Alumno');
        $user13 = User::where('email', 'angel@gmail.com')->first(); $user13->assignRole('Alumno');
        $user14 = User::where('email', 'migue@gmail.com')->first(); $user14->assignRole('Alumno');
        $user15 = User::where('email', 'javier@gmail.com')->first(); $user15->assignRole('Alumno');
        $user16 = User::where('email', 'joseantonio@gmail.com')->first(); $user16->assignRole('Alumno');
        $user17 = User::where('email', 'david@gmail.com')->first(); $user17->assignRole('Alumno');
        $user18 = User::where('email', 'carlos@gmail.com')->first(); $user18->assignRole('Alumno');
        $user19 = User::where('email', 'joseluis@gmail.com')->first(); $user19->assignRole('Alumno');
        $user20 = User::where('email', 'alejandro@gmail.com')->first(); $user20->assignRole('Alumno');
        $user21 = User::where('email', 'miguelangel@gmail.com')->first(); $user21->assignRole('Alumno');

        //Creacion de alumnos 
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'ANT20032', 'user_id' => '6']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'JOSO200332', 'user_id' => '7']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'FRAO20032', 'user_id' => '8']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'JUAO200332', 'user_id' => '9']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'MANO20032', 'user_id' => '10']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'PERO200332', 'user_id' => '11']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'JESO20032', 'user_id' => '12']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'ANGO200332', 'user_id' => '13']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'MIGM20032', 'user_id' => '14']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'JAVO200332', 'user_id' => '15']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'JOSEO20032', 'user_id' => '16']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'DAVI200332', 'user_id' => '17']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'CARO20032', 'user_id' => '18']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'LUIO200332', 'user_id' => '19']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'ALEO20032', 'user_id' => '20']);
        DB::table('alumnos')->insert(['cuatrimestre' => '3', 'matricula' => 'MIGO200332', 'user_id' => '21']);
        
        // Cobertura de visibilidad completa
        
        $user->givePermissionTo(Permission::where('name','academico.index')->get());
        $user->givePermissionTo(Permission::where('name','academico.store')->get());
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $user->givePermissionTo(Permission::where('name','academico.delete')->get());

        $perfil->givePermissionTo(Permission::where('module_key', 'modulo')->get());
        
        $user->givePermissionTo(Permission::where('name','academico.update')->get());
        $perfil->givePermissionTo(Permission::where('module_key', 'cat')->get());

    }
}
