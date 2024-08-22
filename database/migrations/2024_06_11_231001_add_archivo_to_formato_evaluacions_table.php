<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('formato_evaluacions', function (Blueprint $table) {
        $table->string('archivo')->nullable();
    });
}

public function down()
{
    Schema::table('formato_evaluacions', function (Blueprint $table) {
        $table->dropColumn('archivo');
    });
}
};
