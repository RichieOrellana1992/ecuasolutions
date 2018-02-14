<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class provincias extends Katana  {
	
	protected $table = 'tb_provincia';
	protected $primaryKey = 'provincia_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " select tb_provincia.*, tb_pais.codigo_pais
from tb_provincia 
left join tb_pais on tb_pais.pais_id = tb_provincia.pais_id
 ";
	}	

	public static function queryWhere(  ){
		
		return "  where tb_provincia.provincia_id is not null ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
