<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class parroquias extends Katana  {
	
	protected $table = 'tb_parroquia';
	protected $primaryKey = 'parroquia_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " select tb_parroquia.*, tb_canton.codigo_canton from tb_parroquia
left join tb_canton on tb_canton.canton_id = tb_parroquia.canton_id
 ";
	}	

	public static function queryWhere(  ){
		
		return "   where tb_parroquia.parroquia_id is not null ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
