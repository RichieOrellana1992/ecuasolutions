<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GrupoSeed::class);
        $this->call(UsuarioSeed::class);
        $this->call(MenuSeed::class);
        $this->call(ModuloSeed::class);
        $this->call(GrupoAccesoSeed::class);
        $this->call(PaisSeed::class);
    }
}
