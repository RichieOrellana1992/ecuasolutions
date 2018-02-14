<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_grupos_acceso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo_id')->nullable()->default(null);
            $table->integer('modulo_id')->nullable()->default(null);
            $table->text('datos_acceso');
            //laves foraneas
//            $table->foreign('grupo_id')->references('grupo_id')->on('tb_grupos');
//            $table->foreign('modulo_id')->references('modulo_id')->on('tb_modulo');
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
