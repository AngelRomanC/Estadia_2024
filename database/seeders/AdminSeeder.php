<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cobertura de visibilidad completa para el admin
        $adminPerfil = Role::where('name', 'Admin')->first();
        $adminPerfil->givePermissionTo(Permission::where('module_key', 'seguridad')->get());
    }
}
