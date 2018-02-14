<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_modulo', function (Blueprint $table) {
            $table->increments('modulo_id');
            $table->string('modulo_nombre', 100)->nullable()->default(null);
            $table->string('modulo_titulo', 100)->nullable()->default(null);
            $table->string('modulo_nota', 255)->nullable()->default(null);
            $table->string('modulo_autor', 100)->nullable()->default(null);
            $table->timestamp('modulo_creacion')->nullable()->default(null);
            $table->text('modulo_desc')->nullable()->default('');
            $table->string('modulo_db', 255)->nullable()->default(null);
            $table->string('modulo_db_key', 100)->nullable()->default(null);
            $table->string('modulo_type', 20)->nullable()->default('nativo');
            $table->longText('modulo_config')->nullable()->default(null);
            $table->text('modulo_lang')->nullable()->default(null);;
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
