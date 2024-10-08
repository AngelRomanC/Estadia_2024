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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->integer('grado');
            $table->string('grupo');
            $table->integer('estatus');
            $table->unsignedBigInteger("periodo_id")->nullable();
            $table->foreign("periodo_id")->references("id")->on("periodos")->onDelete("cascade");
            $table->unsignedBigInteger("profesor_id")->nullable();
            $table->foreign("profesor_id")->references("id")->on("profesors")->onDelete("cascade");
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
        Schema::dropIfExists('grupos');
    }
};
