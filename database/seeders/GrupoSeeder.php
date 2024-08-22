<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create(['grado'=>'1','grupo'=>'A','periodo_id'=>'3','profesor_id'=>'1','estatus'=>'0']);
        Grupo::create(['grado'=>'1','grupo'=>'B','periodo_id'=>'3','profesor_id'=>'2','estatus'=>'0']);
        

    }
}
