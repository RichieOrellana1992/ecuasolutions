<?php namespace App\Models;

use App\Http\Controllers\controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;


class Katana extends Model {

	public function __construct() 
	{
		parent::__construct();

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

		$limitConditional = ($page !=0 && $limit !=0) ? "OFFSET  $offset ROWS FETCH NEXT $limit ROWS ONLY" : '';
		/* Added since version 5.1.7 */
		if($fstart !='' && $flimit != '')
			$limitConditional = "LIMIT  $fstart , $flimit" ;
		/* End Added since version 5.1.7 */

		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 )
				$params .= " AND {$table}.entry_by ='".$gid."'"; 	
		// End Update permission global / own access new ver 1.1			
        
		$rows = array();
	    $result = \DB::select( self::querySelect() . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional} {$limitConditional} ");
		
		$total = \DB::select( "SELECT COUNT(*) AS total FROM ".$table." " . self::queryWhere(). " 
				{$params} ". self::queryGroup() );
		$total = (count($total) != 0 ? $total[0]->total : 0 );

		return $results = array('rows'=> $result , 'total' => $total);	


	
	}	

	public static function getRow( $id )
	{
       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

		$result = \DB::select( 
				self::querySelect() . 
				self::queryWhere().
				" AND ".$table.".".$key." = '{$id}' ". 
				self::queryGroup()
			);	
		if(count($result) <= 0){
			$result = array();		
		} else {

			$result = $result[0];
		}
		return $result;		
	}	

	public static function prevNext( $id ){

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

	   $prev = '';
	   $next = '';

		$Qnext = \DB::select( 
			self::querySelect() . 
			self::queryWhere().
			" AND ".$table.".".$key." > '{$id}'  ". 
			self::queryGroup()
		);	


		if(count($Qnext)>=1)   $next = $Qnext[0]->{$key};
		
		$Qprev  = \DB::select( 
			self::querySelect() . 
			self::queryWhere().
			" AND ".$table.".".$key." < '{$id}'". 
			self::queryGroup()." ORDER BY ".$table.".".$key
		);	
		if(count($Qprev)>=1)  $prev = $Qprev[0]->{$key};

		return array('prev'=>$prev , 'next'=> $next);	
	}

	public  function insertRow( $data , $id)
	{
        $table = with(new static)->table;
	    $key = with(new static)->primaryKey;
	    if($id == NULL || $id == '0')
        {
            // Insert Here
            if(isset($data['f_creacion'])) $data['f_creacion'] = date("Y-d-m H:i:s");
            if(isset($data['f_modificacion'])) $data['f_modificacion'] = date("Y-d-m H:i:s");
            $id = \DB::table( $table)->insertGetId($data);
            
        } else {
            // Update here
			// update created field if any
			if(isset($data['f_creacion'])) unset($data['f_creacion']);
			if(isset($data['id'])) unset($data['id']);
			 \DB::table($table)->where($key,$id)->update($data);
        }
        return $id;    
	}

	static function makeInfo( $id )
	{
		$row =  \DB::table('tb_modulo')->where('modulo_nombre', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$langs = (json_decode($r->modulo_lang,true));
			$data['id']		= $r->modulo_id;
			$data['title'] 	= \SiteHelpers::infoLang($r->modulo_titulo,$langs,'title');
			$data['note'] 	= \SiteHelpers::infoLang($r->modulo_nota,$langs,'note');
			$data['table'] 	= $r->modulo_db;
			$data['key'] 	= $r->modulo_db_key;
			$data['type'] 	= $r->modulo_type;
			$data['config'] = \SiteHelpers::CF_decode_json($r->modulo_config);
			$field = array();	
			foreach($data['config']['grid'] as $fs)
			{
				foreach($fs as $f)
					$field[] = $fs['field']; 	
									
			}
			$data['field'] = $field;	
			$data['setting'] = array(
				'gridtype'		=> (isset($data['config']['setting']['gridtype']) ? $data['config']['setting']['gridtype'] : 'native'  ),
				'orderby'		=> (isset($data['config']['setting']['orderby']) ? $data['config']['setting']['orderby'] : $r->modulo_db_key),
				'ordertype'		=> (isset($data['config']['setting']['ordertype']) ? $data['config']['setting']['ordertype'] : 'asc'  ),
				'perpage'		=> (isset($data['config']['setting']['perpage']) ? $data['config']['setting']['perpage'] : '10'  ),
				'frozen'		=> (isset($data['config']['setting']['frozen']) ? $data['config']['setting']['frozen'] : 'false'  ),
	            'form-method'   => (isset($data['config']['setting']['form-method'])  ? $data['config']['setting']['form-method'] : 'native'  ),
	            'view-method'   => (isset($data['config']['setting']['view-method'])  ? $data['config']['setting']['view-method'] : 'native'  ),
	            'inline'        => (isset($data['config']['setting']['inline'])  ? $data['config']['setting']['inline'] : 'false'  ),				
				
			);			
					
		}

		return $data;
	} 

    static function getComboselect( $params , $limit =null, $parent = null)
    {   
        $limit = explode(':',$limit);
        $parent = explode(':',$parent);

        if(count($limit) >=3)
        {
            $table = $params[0]; 
            $condition = $limit[0]." `".$limit[1]."` ".$limit[2]." '".$limit[3]."' "; 
            if(count($parent)>=2 )
            {
            	$row =  \DB::table($table)->where($parent[0],$parent[1])->get();
            	 $row =  \DB::select( "SELECT * FROM ".$table." ".$condition ." AND ".$parent[0]." = '".$parent[1]."'");
            } else  {
	           $row =  \DB::select( "SELECT * FROM ".$table." ".$condition);
            }        
        }else{

            $table = $params[0]; 
            if(count($parent)>=2 )
            {
            	$row =  \DB::table($table)->where($parent[0],$parent[1])->get();
            } else  {
	            $row =  \DB::table($table)->get();
            }	           
        }

        return $row;
    }	

	public static function getColoumnInfo( $result )
	{
		$pdo = \DB::getPdo();
		$res = $pdo->query($result);
        $i =0;	$coll=array();
        while ($i < $res->columnCount())
        {
            $info = $res->getColumnMeta($i);
			$coll[] = $info;
			$i++;
		}
		return $coll;	
	
	}

	function isAccess( $id , $task , $gid )
	{
		
		$row = \DB::table('tb_grupos_acceso')->where('modulo_id', $id)->where('grupo_id', $gid )->get();
		
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
				return $data[$task];	
			} else {
				return  0;
			}	

				
			
		} else {
			return 0;
		}			
	
	}

	function validAccess( $id , $gid = 0)
	{
		$row = \DB::table('tb_grupos_acceso')->where('modulo_id', $id)->where('grupo_id', $gid )->get();
		
		if(count($row) >= 1)
		{
			$row = $row[0];
			if($row->datos_acceso !='')
			{
				$data = json_decode($row->datos_acceso,true);
			} else {
				$data = array();
			}	
			return $data;		
			
		} else {
			return false;
		}			
	
	}	

	static function getColumnTable( $table )
	{
        $columns = array();
        $cls= \DB::getSchemaBuilder()->getColumnListing($table);
        foreach($cls as $column)
        {
            $columns[$column] = '';
        }
        return $columns;
	}	

	static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'dbname';
        $type_db = env('DB_CONNECTION', false);
        $sql = "SHOW TABLES FROM {$db}";
        if($type_db == 'sqlsrv')
            $sql = "select Table_name as dbname
                    from Information_schema.Tables
                    where Table_type = 'BASE TABLE' 
                    and Objectproperty (Object_id(Table_name), 'IsMsShipped') = 0
                    and Table_catalog = '{$db}'";

		foreach(\DB::select($sql) as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}	
	
	static function getTableField( $table ) 
	{
        $columns = array();
        $cls= \DB::getSchemaBuilder()->getColumnListing($table);
	    foreach($cls as $column)
		    $columns[$column] = $column;
        return $columns;
	}	

	public function logs( $request , $id )
	{
		 $key = with(new static)->primaryKey;
		if($request->input( $key)  =='')
		{
			$note = 'Nuevos Datos con ID '.$id.' Han sido Ingresados !';
		} 
		else {
			$note = 'El Registro con ID '.$id.' Ha sido Actualizado !';
		}
//		dd($request->segment(1), $request->segment(2));
		$data = array(
			'modulo'	=> $request->segment(1),
			'tarea'		=> $request->segment(2),
			'usuario_id'	=> \Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'nota'		=> $note
		);
		\DB::table('tb_logs')->insert($data);
	}

}
