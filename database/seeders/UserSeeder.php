<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creacion de usuarios
        DB::table('users')->insert(['name' => 'Administrador', 'email' => 'admin@gmail.com', 'password' => Hash::make('12345678'),]);
        DB::table('users')->insert(['name' => 'Javier Villagrán', 'email' => 'Javier@gmail.com', 'password' => Hash::make('12345678'),]);
        DB::table('users')->insert(['name' => 'Jose Ortega', 'email' => 'Jose@gmail.com', 'password' => Hash::make('12345678'),]);

        // Roles del sistema
        $admin = Role::create(['name' => 'Admin', 'description' => 'Administrador']);
        $promotor = Role::create(['name' => 'Promotor', 'description' => 'Promotor de agencia']);
        $agente = Role::create(['name' => 'Agente', 'description' => 'Agente']);

        User::find(1)->assignRole($admin);
        User::find(2)->assignRole($promotor);
        User::find(3)->assignRole($agente);

    }
}
