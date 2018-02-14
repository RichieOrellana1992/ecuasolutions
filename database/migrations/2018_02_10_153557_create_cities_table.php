<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_canton', function (Blueprint $table) {
            $table->increments('canton_id');
            $table->integer('provincia_id')->unsigned()->nullable()->default(0);
            $table->string('codigo_canton', 20)->nullable()->default(null);
            $table->text('descripcion', 100)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default(1);
            $table->timestamp('f_modificacion')->nullable()->default(null);
            $table->timestamp('f_creacion')->nullable()->default(null);
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
