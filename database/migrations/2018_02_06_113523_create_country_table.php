<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pais', function (Blueprint $table) {
            $table->increments('pais_id');
            $table->string('codigo_pais', 20);
            $table->string('descripcion', 100)->nullable()->default(null);
            $table->string('bandera', 10)->nullable();
            $table->tinyInteger('activo')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
