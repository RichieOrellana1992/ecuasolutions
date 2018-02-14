<?php

use Illuminate\Database\Seeder;

class GrupoAccesoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_grupos_acceso')->delete();
        DB::unprepared ('set identity_insert tb_grupos_acceso on ');
        $array = array([
            'id' => 1,
            'grupo_id' => 1,
            'modulo_id' => 1,
            'datos_acceso' => '{"is_global":"1","is_view":"1","is_detail":"1","is_add":"1","is_edit":"1","is_remove":"1","is_excel":"1"}'
        ],[
            'id' => 2,
            'grupo_id' => 2,
            'modulo_id' => 1,
            'datos_acceso' => '{"is_global":"1","is_view":"1","is_detail":"1","is_add":"1","is_edit":"1","is_remove":"1","is_excel":"1"}'
        ],[
            'id' => 3,
            'grupo_id' => 3,
            'modulo_id' => 1,
            'datos_acceso' => '{"is_global":"0","is_view":"0","is_detail":"0","is_add":"0","is_edit":"0","is_remove":"0","is_excel":"0"}'
        ],[
            'id' => 4,
            'grupo_id' => 1,
            'modulo_id' => 2,
            'datos_acceso' => '{"is_global":"1","is_view":"1","is_detail":"1","is_add":"1","is_edit":"1","is_remove":"1","is_excel":"1"}'
        ],[
            'id' => 5,
            'grupo_id' => 2,
            'modulo_id' => 2,
            'datos_acceso' => '{"is_global":"1","is_view":"1","is_detail":"1","is_add":"1","is_edit":"1","is_remove":"1","is_excel":"1"}'
        ],[
            'id' => 6,
            'grupo_id' => 3,
            'modulo_id' => 2,
            'datos_acceso' => '{"is_global":"0","is_view":"0","is_detail":"0","is_add":"0","is_edit":"0","is_remove":"0","is_excel":"0"}'
        ]);
        DB::table('tb_grupos_acceso')->insert($array);
        DB::unprepared ('set identity_insert tb_grupos_acceso off');
    }
}
