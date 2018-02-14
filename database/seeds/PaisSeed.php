<?php

use Illuminate\Database\Seeder;

class PaisSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared ('set identity_insert tb_pais on ');
        DB::table('tb_pais')->delete();
        //Get all of the countries
        $array = array([
            'pais_id' => 1,
            'codigo' => 'EC',
            'nombre' => 'Ecuador',
            'bandera' => 'EC.png',
            "moneda"=>"US Dolar",
            "moneda_simbolo"=>"$",
            "moneda_codigo"=>"USD",
            "moneda_decimales"=>"2"
        ]);
        DB::table('tb_pais')->insert($array);
        DB::unprepared ('set identity_insert tb_pais off ');
    }
}
