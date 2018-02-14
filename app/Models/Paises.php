<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class paises extends Katana  {
	
	protected $table = 'tb_pais';
	protected $primaryKey = 'pais_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " select tb_pais.*
from tb_pais
 ";
	}	

	public static function queryWhere(  ){
		
		return "   where tb_pais.pais_id is not null ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
