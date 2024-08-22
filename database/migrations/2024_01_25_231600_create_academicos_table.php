<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academicos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula');
            $table->integer('estatus');
            $table->integer('version');
            $table->integer('formato');
            $table->integer('numero');
            $table->foreignId('grupo_id')->constrained(); 
            $table->foreignId('user_id')->constrained(); 
            $table->foreignId('periodo_id')->constrained();
            $table->foreignId('profesor_id')->constrained();
            $table->timestamps();
        });

        Schema::create('materias_acumuladas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias'); // Clave foránea de materia
            $table->foreignId('academico_id')->constrained('academicos'); // Clave foránea de academico
            $table->foreignId('periodo_id')->constrained('periodos');
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materias_acumuladas');
        Schema::dropIfExists('academicos');
    }
};
