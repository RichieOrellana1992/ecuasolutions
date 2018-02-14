<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_logs', function (Blueprint $table) {
            $table->increments('logID');
            $table->string('ipaddress', 50);
            $table->integer('usuario_id')->unsigned()->nullable()->default(null);
            $table->string('modulo')->nullable()->default(null);
            $table->string('tarea')->nullable()->default(null);
            $table->string('nota')->nullable()->default(null);
            $table->timestamp('log_fecha')->default(\DB::raw('CURRENT_TIMESTAMP'));
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
