<?php namespace App\Models\Core;

use App\Models\Katana;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Katana  {
	
	protected $table = 'tb_usuarios';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " 
			SELECT  tb_usuarios.*,  tb_grupos.codigo
			FROM tb_usuarios LEFT JOIN tb_grupos ON tb_grupos.grupo_id = tb_usuarios.grupo_id 
		";
	}	

	public static function queryWhere(  ){
		
		return "    WHERE tb_usuarios.id !=''   ";
	}
	
	public static function queryGroup(){
		return "      ";
	}

	public static function getRows( $args , $gid = 0 )
	{

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	   
        extract( array_merge( array(
			'page' 		=> '0' ,
			'limit'  	=> '0' ,
			'sort' 		=> '' ,
			'order' 	=> '' ,
			'params' 	=> '' ,
			'flimit' 	=> '' ,
			'fstart' 	=> '' ,
			'global'	=> 1	  
        ), $args ));

		$offset = ($page-1) * $limit ;
//        $limitConditional = ($page !=0 && $limit !=0) ? "TOP  $offset , $limit" : '';
        /* Added since version 5.1.7 */
//		if($fstart !='' && $flimit != '')
//			$limitConditional = "LIMIT  $fstart , $flimit" ;
		/* End Added since version 5.1.7 */

		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 )
				$params .= " AND {$table}.entry_by ='".$gid."'"; 	
		// End Update permission global / own access new ver 1.1			
        
		$rows = array();
	    $result = \DB::select( self::querySelect() . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional}  ");
		
		$total = \DB::select( "
				SELECT  count(tb_usuarios.id) as total 
			FROM tb_usuarios LEFT JOIN tb_grupos ON tb_grupos.grupo_id = tb_usuarios.grupo_id " . self::queryWhere(). " 
				{$params} ". self::queryGroup() );
		$total = (count($total) != 0 ? $total[0]->total : 0 );

		return $results = array('rows'=> $result , 'total' => $total);	


	
	}	

	
	public static function level( $id ) {

		$group_id = 0;
		$sql = \DB::table('tb_grupos')->where('grupo_id',$id)->get();
		if(count($sql)){
			$row = $sql[0];
			$group_id = $row->nivel;
		}
		return $group_id;
			
	}

}
