<?php

use Illuminate\Database\Seeder;

class MenuSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared ('set identity_insert tb_menu on');
        DB::table('tb_menu')->delete();
        $array = array([
            'menu_id' => 2,
            'padre_id' => 0,
            'modulo' => 'contact-us',
            'url' => '',
            'menu_nombre' => 'Contactos',
            'menu_tipo' => 'internal',
            'rol_id' => null,
            'profundidad' => null,
            'orden' => 3,
            'posicion' => 'top',
            'menu_iconos' => 'mdi mdi-google-maps fa-fw',
            'activo' => 1,
            'datos_acceso' => '{"1":"0","2":"0","3":"0"}',
            'menu_lang' => '{"title":{"id":""}}'
        ],[
            'menu_id' => 12,
            'padre_id' => 0,
            'modulo' => 'about-us',
            'url' => '',
            'menu_nombre' => 'About',
            'menu_tipo' => 'internal',
            'rol_id' => null,
            'profundidad' => null,
            'orden' => 0,
            'posicion' => 'top',
            'menu_iconos' => 'fa',
            'activo' => 1,
            'datos_acceso' => '{"1":"0","2":"0","3":"0"}',
            'menu_lang' => '{"title":{"id":""}}'
        ],[
            'menu_id' => 17,
            'padre_id' => 0,
            'modulo' => 'posts',
            'url' => null,
            'menu_nombre' => 'Blog',
            'menu_tipo' => 'internal',
            'rol_id' => null,
            'profundidad' => null,
            'orden' => 2,
            'posicion' => 'top',
            'menu_iconos' => null,
            'activo' => 1,
            'datos_acceso' => '{"1":"0","2":"0","3":"0"}',
            'menu_lang' => '{"title":{"id":""}}'
        ],[
            'menu_id' => 26,
            'padre_id' => 0,
            'modulo' => 'service',
            'url' => null,
            'menu_nombre' => 'What We Do',
            'menu_tipo' => 'internal',
            'rol_id' => null,
            'profundidad' => null,
            'orden' => 1,
            'posicion' => 'top',
            'menu_iconos' => null,
            'activo' => 1,
            'datos_acceso' => '{"1":"1","2":"0","3":"0"}',
            'menu_lang' => '{"title":{"id":""}}'
        ]);
        DB::table('tb_menu')->insert($array);
        DB::unprepared ('set identity_insert tb_menu off ');
    }
}
