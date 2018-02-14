<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_menu', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->integer('padre_id')->default(0);
            $table->string('modulo', 50)->nullable()->default(null);
            $table->string('url', 100)->nullable()->default(null);
            $table->string('menu_nombre', 100)->nullable()->default(null);
            $table->char('menu_tipo', 10)->nullable()->default(null);
            $table->char('rol_id', 10)->nullable()->default(null);
            $table->smallInteger('profundidad')->nullable()->default(null);
            $table->integer('orden')->nullable()->default(null);
            $table->enum('posicion', ['top','sidebar','both'])->nullable()->default(null);
            $table->string('menu_iconos', 30)->nullable()->default(null);
            $table->enum('activo', ['0','1'])->nullable()->default('1');
            $table->text('datos_acceso')->nullable()->default(null);
            $table->text('menu_lang')->nullable()->default(null);
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
