<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class cantones extends Katana  {
	
	protected $table = 'tb_canton';
	protected $primaryKey = 'canton_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " select tb_canton.*, tb_provincia.codigo_provincia 
from tb_canton
left join tb_provincia on tb_provincia.provincia_id = tb_canton.provincia_id ";
	}	

	public static function queryWhere(  ){
		
		return "   where tb_canton.canton_id is not null ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
