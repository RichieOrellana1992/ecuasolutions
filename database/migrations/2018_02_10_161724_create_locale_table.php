<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_parroquia', function (Blueprint $table) {
            $table->increments('parroquia_id');
            $table->integer('canton_id')->unsigned()->nullable()->default(0);
            $table->string('codigo_parroquia', 20)->nullable()->default(null);
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
