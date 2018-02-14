<?php

use Illuminate\Database\Seeder;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_usuarios')->delete();
        DB::unprepared ('set identity_insert tb_usuarios on');
        $array = array([
            'id' => 1,
            'username' => 'superadmin',
            'password' => '$2y$10$ty.TpWnEjBOk1hoI3M0WIOnyVvrjcyLZ4/7LE9fnBOVRtc4cZekkW',
            'email' => 'info@ecuasolutions.com',
            'nombres' => 'Ricardo Ecuardo',
            'apellidos' => 'Orellana Yanza',
            'avatar' => '1.jpg',
            'activo' => 1,
            'intentos_login' => 12,
            'ultimo_login' => '2017-02-01 00:45:41',
            'created_at' => '2014-12-03 09:18:46',
            'updated_at' => '2017-05-05 05:01:33',
            'recordatorio' => 'SNLyM4Smv12Ck8jyopZJMfrypTbEDtVhGT5PMRzxs',
            'ultima_actividad' => 1485431605,
            'remember_token' => 'C0cPNe77meFPJLMp3aTgh6RhBS0VpYqD6kJAiNC864gwAo9fKJJdlkwxqK5o',
            'configuracion' => NULL,
            'grupo_id' => 1
        ],[
            'id' => 2,
            'username' => 'maicoly',
            'password' => '$2y$10$foJoRSkADvm9WfnTkCLUauWG5lAXr5ub9.Ht2NX1RVA1GbTskyjAe',
            'email' => 'soporte@ecuasolutions.com',
            'nombres' => 'Maicoly',
            'apellidos' => 'Morocho',
            'avatar' => '2.jpg',
            'activo' => 1,
            'intentos_login' => 0,
            'ultimo_login' => '2017-02-02 10:11:09',
            'created_at' => '2014-25-09 22:49:23',
            'updated_at' => '2017-18-03 20:37:18',
            'recordatorio' => '',
            'ultima_actividad' => 1479821075,
            'remember_token' => 'ZbHClz4PaPXDMirJNeEfR5BiJGrmltiQei1j86lAihuEQZn7qK5McfFm20bL',
            'configuracion' => NULL,
            'grupo_id' => 2,
        ]);
        DB::table('tb_usuarios')->insert($array);
        DB::unprepared ('set identity_insert tb_usuarios off');
    }
}
