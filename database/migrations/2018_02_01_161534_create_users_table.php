<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50)->unique();
            $table->integer('grupo_id')->unsigned()->nullable()->default(null);
            $table->string('password', 64);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('nombres', 50)->nullable()->default(null);
            $table->string('apellidos', 50)->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->tinyInteger('activo')->unsigned()->nullable()->default(null);
            $table->tinyInteger('intentos_login')->nullable()->default(0);
            $table->dateTime('ultimo_login')->nullable()->default(null);
            $table->string('recordatorio', 64)->nullable()->default(null);
            $table->integer('ultima_actividad')->nullable()->default(null);
            $table->string('configuracion')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
            //llaves foraneas
//            $table->foreign('grupo_id')->references('grupo_id')->on('tb_grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_usuarios');
    }
}
