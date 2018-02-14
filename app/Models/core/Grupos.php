<?php namespace App\Models\Core;

use  App\Models\Katana;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Katana  {
	
	protected $table = 'tb_grupos';
	protected $primaryKey = 'grupo_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT  
	tb_grupos.grupo_id,
	tb_grupos.codigo,
	tb_grupos.descripcion,
	tb_grupos.nivel


FROM tb_grupos  ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE tb_grupos.grupo_id IS NOT NULL    ";
	}
	
	public static function queryGroup(){
		return "    ";
	}
	

}
