<?php

use Illuminate\Database\Seeder;

class GrupoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_grupos')->delete();
        DB::unprepared ('set identity_insert tb_grupos on ');
        $array = array([
            'grupo_id' => 1,
            'codigo' => 'superadmin',
            'descripcion' => 'Root Superadmin, grupo de mas alto nivel.',
            'nivel' => 1
        ],[
            'grupo_id' => 2,
            'codigo' => 'administrador',
            'descripcion' => 'Administradores del sistema.',
            'nivel' => 2
        ],
        [
            'grupo_id' => 3,
            'codigo' => 'usuarios',
            'descripcion' => 'Miembros del sistema.',
            'nivel' => 1
        ]);
        DB::table('tb_grupos')->insert($array);
        DB::unprepared ('set identity_insert tb_grupos off');
    }
}
