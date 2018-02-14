<?php

namespace App\Http\Controllers\katana;

use App\Http\Controllers\Controller;
use App\Models\katana\Modulo;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Validator, Input, Redirect;
class ModuloController extends Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->middleware(function ($request, $next) {
            if(session('gid') !='1')
                return redirect('dashboard')
                    ->with('message','You Dont Have Access to Page !')->with('status','error');
            return $next($request);
        });

        $driver             = config('database.default');
        $database           = config('database.connections');

        $this->db           = $database[$driver]['database'];
        $this->dbuser       = $database[$driver]['username'];
        $this->dbpass       = $database[$driver]['password'];
        $this->dbhost       = $database[$driver]['host'];
        $this->model = new Modulo();


        $this->data = array_merge(array(
            'pageTitle' =>  'Módulo',
            'pageNote'  =>  'Administrar todo el Módulo',

        ),$this->data)  ;
    }

    public function index( Request $request)
    {

        if(!is_null($request->input('t')))
        {
            $rowData = \DB::table('tb_modulo')->where('modulo_type','=','core')
                ->orderby('modulo_titulo','asc')->get();
            $type = 'core';
        } else {
            $rowData = \DB::table('tb_modulo')->where('modulo_type','!=','core')
                ->orderby('modulo_titulo','asc')->get();
            $type = 'addon';
        }

        $this->data['type']    = $type;
        $this->data['rowData'] = $rowData;
        return view('katana.modulo.index',$this->data);
    }

    function getCreate()
    {

        $this->data = array(
            'pageTitle'    => 'Crear nuevo Módulo',
            'pageNote'    => 'Crear un módulo rápido ',
        );
        $this->data['tables'] = Modulo::getTableList($this->db);
        $this->data['cruds'] = \SiteHelpers::crudOption();
        return view('katana.modulo.create',$this->data);

    }

    function getSql(Request $request , $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $this->data['sql_select']     	= $config['sql_select'];
        $this->data['sql_where']     	= $config['sql_where'];
        $this->data['sql_group']     	= $config['sql_group'];
        $this->data['modulo_nombre'] 		= $row->modulo_nombre;
        $this->data['module'] 			= 'module';
        $this->data['type']             = ($row->modulo_type =='ajax' ? 'addon' : $row->modulo_type);

        return view('katana.modulo.sql',$this->data);

    }

    function postSavesql( Request $request ,$id )
    {

        $select     = $request->input('sql_select');
        $where     = $request->input('sql_where');
        $group     = $request->input('sql_group');

        try {
            \DB::select( $select .' '.$where.' '.$group );

        }catch(Exception $e){
            // Do something when query fails.
            $error ='Error : '.$select .' '.$where.' '.$group ;
            return redirect('katana/modulo/sql/'.$request->input('modulo_nombre'))
                ->with('message', $error)->with('status','error');
        }

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect($this->modulo)
                ->with('message','Can not find module')->with('status','error');
        }

        $row = $row[0];
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);

        $this->data['row'] = $row;

        $pdo = \DB::getPdo();
        $columns = Modulo::getColoumnInfo($select .' '.$where.' '.$group);
        $i =0;$form =array(); $grid = array();
        foreach($columns as $field)
        {


            $name = $field['name'];    $alias = $field['table'];
            $grids =  self::configGrid( $name , $alias , '' ,$i);

            foreach($config['grid'] as $g)
            {
                if(!isset($g['type'])) $g['type'] = 'text';
                if($g['field'] == $name && $g['alias'] == $alias)
                {
                    $grids = $g;
                }
            }
            $grid[] = $grids ;

            if($row->modulo_db == $alias )
            {
                $forms = self::configForm($name,$alias,'text',$i);
                foreach($config['forms'] as $f)
                {
                    if($f['field'] == $name && $f['alias'] == $alias)
                    {
                        $forms = $f;
                    }
                }
                $form[] = $forms ;
            }


            $i++;
        }


        // Remove Old Grid
        unset($config["forms"]);
        // Remove Old Form
        unset($config["grid"]);
        // Remove Old Query
        unset($config["sql_group"]);
        unset($config["sql_select"]);
        unset($config["sql_where"]);

        // Inject New Grid
        $new_config = array(
            "sql_select"         => $select ,
            "sql_where"            => $where ,
            "sql_group"            => $group,
            "grid"                 => $grid,
            "forms"             => $form
        );

        $config =     array_merge($config,$new_config);


        \DB::table('tb_modulo')
            ->where('modulo_id', '=',$row->modulo_id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($config)));

        if($request->ajax() == true)
        {
            return response()->json(array('status'=>'success','message'=>'SQL ha sido cambiado correctamente!'));
        } else {

            return redirect('katana/modulo/sql/'.$row->modulo_nombre)
                ->with('message','SQL Has Changed Successful.')->with('status','success');
        }

    }

    public function postSavepermission( Request $request)
    {

        $id = $request->input('modulo_id');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);

        $fp = base_path().'/resources/views/katana/modulo/template/'.$this->getTemplateName($row->modulo_type).'/config/info.json';
        $fp = json_decode(file_get_contents($fp),true);
        $tasks = $fp['access'];
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row)
            {
                $tasks[$row['item']] = $row['title'];
            }
        }

        $permission = array();
        $groupID = $request->input('grupo_id');
        for($i=0;$i<count($groupID); $i++)
        {
            // remove current group_access
            $group_id = $groupID[$i];
            \DB::table('tb_grupos_acceso')
                ->where('modulo_id','=',$request->input('modulo_id'))
                ->where('grupo_id','=',$group_id)
                ->delete();

            $arr = array();
            $id = $groupID[$i];
            foreach($tasks as $t=>$v)
            {
                $arr[$t] = (isset($_POST[$t][$id]) ? "1" : "0" );

            }
            $permissions = json_encode($arr);

            $data = array
            (
                "datos_acceso"    => $permissions,
                "modulo_id"        => $request->input('modulo_id'),
                "grupo_id"        => $groupID[$i],
            );
            \DB::table('tb_grupos_acceso')->insert($data);
        }

        if($request->ajax() == true)
        {
            return response()->json(array('status'=>'success','message'=>'Los permisos se han cambiado correctamente'));
        } else {

            return redirect('katana/modulo/permission/'.$row->modulo_nombre)
                ->with('message','Permission Has Changed Successful')->with('status','success');
        }

    }


    function removeDir($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                self::removeDir($file);
            else
                unlink($file);
        }
        if(is_dir($dir)) rmdir($dir);
    }

    function getConfig( $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('six/module')->with('message','Can not find module')->with('status','error');

        }
        $row = $row[0];
        $this->data['row'] = $row;

        // Get config Info
        $fp = base_path().'/resources/views/katana/modulo/template/'.$this->getTemplateName($row->modulo_type).'/config/info.json';
        $fp = json_decode(file_get_contents($fp));
        $this->data['config'] = $fp;
        $this->data['cruds'] = \SiteHelpers::crudOption();



        //

        $this->data['modulo'] = 'modulo';
        $this->data['modulo_lang'] = json_decode($row->modulo_lang,true);
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config,true);
        $this->data['tables']     = $config['grid'];
        $this->data['type']     = ($row->modulo_type =='ajax' ? 'addon' : $row->modulo_type);
        $this->data['setting'] = array(
            'gridtype'        => (isset($config['setting']) ? $config['setting']['gridtype'] : 'native'  ),
            'orderby'        => (isset($config['setting']) ? $config['setting']['orderby'] : $row->modulo_db_key  ),
            'ordertype'        => (isset($config['setting']) ? $config['setting']['ordertype'] : 'asc'  ),
            'perpage'        => (isset($config['setting']) ? $config['setting']['perpage'] : '10'  ),
            'frozen'        => (isset($config['setting']['frozen'])  ? $config['setting']['frozen'] : 'false'  ),
            'form-method'        => (isset($config['setting']['form-method'])  ? $config['setting']['form-method'] : 'native'  ),
            'view-method'        => (isset($config['setting']['view-method'])  ? $config['setting']['view-method'] : 'native'  ),
            'inline'        => (isset($config['setting']['inline'])  ? $config['setting']['inline'] : 'false'  ),
        );
        return view('katana.modulo.config',$this->data);

    }

    function getBuild( $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','No se puede encontrar el módulo')->with('status','error');
        }
        $row = $row[0];

        $this->data['modulo'] = 'modulo';
        $this->data['modulo_nombre'] = $id;
        $this->data['modulo_id'] = $row->modulo_id;
        return view('katana.modulo.build',$this->data);

    }

    function postSaveconfig( Request $request)
    {

        $rules = array(
            'modulo_titulo'=>'required',
            'modulo_id'  =>'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = array(
                'modulo_titulo'    	=> $request->input('modulo_titulo'),
                'modulo_nota'    	=> $request->input('modulo_nota'),
            );
            $lang = \SiteHelpers::langOption();
            $language =array();
            foreach($lang as $l)
            {
                if($l['folder'] !='es'){
                    $label_lang = (isset($_POST['language_title'][$l['folder']]) ? $_POST['language_title'][$l['folder']] : '');
                    $note_lang = (isset($_POST['language_note'][$l['folder']]) ? $_POST['language_note'][$l['folder']] : '');

                    $language['title'][$l['folder']] = $label_lang;
                    $language['note'][$l['folder']] = $note_lang;
                }
            }

            $data['modulo_lang'] = json_encode($language);
            $id = $request->input('modulo_id');

            \DB::table('tb_modulo')->where('modulo_id', '=',$id )->update($data);

            if($request->ajax() == true)
            {
                return response()->json(array('status'=>'success','message'=>'La información del módulo se ha actualizado Correctamente'));
            } else {

                return redirect('katana/modulo/config/'.$request->input('modulo_nombre'))
                    ->with('message','La información del módulo se ha actualizado Correctamente')->with('status','success');
            }

        } else {

            if($request->ajax() == true)
            {
                return response()->json(array('status'=>'error','message'=>'Ocurrieron los siguientes errores'));
            } else {

                return redirect('katana/modulo/config/'.$request->input('modulo_nombre'))
                    ->with('message','Ocurrieron los siguientes errores')->with('status','error')
                    ->withErrors($validator)->withInput();
            }
        }
    }

    public function postSavetable( Request $request)
    {
        //$this->beforeFilter('csrf', array('on'=>'post'));

        $id = $request->input('modulo_id');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $lang   = \SiteHelpers::langOption();
        $grid   = array();
        $total  = count($_POST['field']);
        extract($_POST);
        for($i=1; $i<= $total ;$i++) {
            $language =array();
            foreach($lang as $l)
            {
                if($l['folder'] !='es'){
                    $label_lang = (isset($_POST['language'][$i][$l['folder']]) ? $_POST['language'][$i][$l['folder']] : '');
                    $language[$l['folder']] =$label_lang;
                }
            }

            $grid[] = array(
                'field'        => $field[$i],
                'alias'        => $alias[$i],
                'language'    => $language,
                'label'        => $label[$i],
                'view'        => (isset($view[$i]) ? 1 : 0 ),
                'detail'    => (isset($detail[$i]) ? 1 : 0 ),
                'sortable'    => (isset($sortable[$i]) ? 1 : 0 ),
                'search'    => (isset($search[$i]) ? 1 : 0 ) ,
                'download'    => (isset($download[$i]) ? 1 : 0 ),
                'frozen'    => (isset($frozen[$i]) ? 1 : 0 ),
                'limited'    => (isset($limited[$i]) ? $limited[$i] : ''),
                'width'        => $width[$i],
                'align'        => $align[$i],
                'sortlist'    => $sortlist[$i],
                'conn'    =>     array(
                    'valid'     => $conn_valid[$i],
                    'db'        => $conn_db[$i],
                    'key'        => $conn_key[$i],
                    'display'    => $conn_display[$i]
                ),
                'format_as'     => (isset($format_as[$i]) ? $format_as[$i] : '' ),
                'format_value'  => (isset($format_value[$i]) ? $format_value[$i] : '' )
            );

        }

        unset($config["grid"]);
        $new_config =     array_merge($config,array("grid" => $grid));
        $data['modulo_config'] = \SiteHelpers::CF_encode_json($new_config);



        \DB::table('tb_modulo')
            ->where('modulo_id', '=',$id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($new_config)));

        if($request->ajax() == true)
        {
            return response()->json(array('status'=>'success','message'=>'La tabla del módulo se ha guardado correctamente.'));
        } else {

            return redirect('katana/modulo/table/'.$row->modulo_nombre)
                ->with('message','La tabla del módulo se ha guardado correctamente.')->with('status','success');
        }

    }

    function postCreate( Request $request)
    {
        $rules = array(
            'modulo_nombre'    =>'required|alpha|min:2|unique:tb_modulo',
            'modulo_titulo'    =>'required',
            'modulo_nota'    =>'required',
            'modulo_db'        =>'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $table = $request->input('modulo_db');
            $primary = self::findPrimarykey($request->input('modulo_db'));
            $select = $request->input('sql_select');
            $where     = $request->input('sql_where');
            $group     = $request->input('sql_group');

            if($request->input('creation') == 'manual')
            {
                if($where =="")
                {
                    return redirect('katana/modulo/create')
                        ->withErrors($validator)->withInput()->with('message', "SQL WHERE REQUIRED")->with('status','error');
                }

                try {

                    \DB::select( $select .' '.$where.' '.$group );



                }catch(Exception $e){
                    // Do something when query fails.
                    $error ='Error : '.$select .' '.$where.' '.$group ;
                    return redirect('katana/modulo/create')
                        ->withErrors($validator)->withInput()->with('message', SiteHelpers::alert('error',$error))->with('status','error');
                }
                $columns = array();
                $results = $this->model->getColoumnInfo($select .' '.$where.' '.$group);
                $primary_exits = '';
                foreach($results as $r)
                {
                    $pre_key = explode(" ", $r['sqlsrv:decl_type']);
                    $Key = (isset($pre_key[1]) && $pre_key[1] =='identity'  ? 'PRI' : '');
                    if($Key !='') $primary_exits = $r['name'];
                    $columns[] = (object) array('Field'=> $r['name'],'Table'=> $r['table'],'Type'=>$r['native_type'],'Key'=>$Key);
                }
                $primary  = ($primary_exits !='' ? $primary_exits : '');



            } else {
                $columns = \DB::select("SHOW COLUMNS FROM ".$request->input('module_db'));
                $select =  " SELECT {$table}.* FROM {$table} ";
                $where = " WHERE ".$table.".".$primary." IS NOT NULL";
                if($primary !='') {
                    $where     = " WHERE ".$table.".".$primary." IS NOT NULL";
                } else { $where  ='' ;}
            }
            $i = 0; $rowGrid = array();$rowForm = array();
            foreach($columns as $column)
            {
                if(!isset($column->Table)|| $column->Table == '') $column->Table = $table;
                if($column->Key =='PRI') $column->Type ='hidden';
                if($column->Table == $table)
                {
                    $form_creator = self::configForm($column->Field,$column->Table,$column->Type,$i);
                    $relation = self::buildRelation($table ,$column->Field);
                    foreach($relation as $row)
                    {
                        $array = array('external',$row['table'],$row['column']);
                        $form_creator = self::configForm($column->Field,$table,'select',$i,$array);

                    }
                    $rowForm[] = $form_creator;
                }

                $rowGrid[] = self::configGrid($column->Field,$column->Table,$column->Type,$i);
                $i++;
            }

            $json_data['sql_select']     = $select;
            $json_data['sql_where']     = $where;
            $json_data['sql_group']        = $group;
            $json_data['table_db']        = $table ;
            $json_data['primary_key']    = $primary;
            $json_data['grid']    = $rowGrid ;
            $json_data['forms']    = $rowForm ;
            $module_type = $primary =='' ? 'report' : $request->input('modulo_template')  ;
            $data = array(
                'modulo_nombre'    => strtolower(trim($request->input('modulo_nombre'))),
                'modulo_titulo'    =>$request->input('modulo_titulo'),
                'modulo_nota'    =>$request->input('modulo_nota'),
                'modulo_db'        =>$request->input('modulo_db'),
                'modulo_db_key' => $primary,
                'modulo_type'     => $module_type,
                'modulo_creacion'     => date("Y-m-d H:i:s"),
                'modulo_config' => \SiteHelpers::CF_encode_json($json_data),
            );


            \DB::table('tb_modulo')->insert($data);

            // Add Default permission
            $tasks = array(
                'is_global'        => 'Global',
                'is_view'        => 'View ',
                'is_detail'        => 'Detail',
                'is_add'        => 'Add ',
                'is_edit'        => 'Edit ',
                'is_remove'        => 'Remove ',
                'is_excel'        => 'Excel ',

            );
            $groups = \DB::table('tb_grupos')->get();
            $row = \DB::table('tb_modulo')->where('modulo_nombre',$request->input('modulo_nombre'))->get();

            if(count($row) >= 1)
            {
                $id = $row[0];

                foreach($groups as $g)
                {
                    $arr = array();
                    foreach($tasks as $t=>$v)
                    {
                        if($g->grupo_id =='1') {
                            $arr[$t] = '1' ;
                        } else {
                            $arr[$t] = '0' ;
                        }

                    }
                    $data = array
                    (
                        "datos_acceso"    => json_encode($arr),
                        "modulo_id"        => $id->modulo_id,
                        "grupo_id"        => $g->grupo_id,
                    );
                    \DB::table('tb_grupos_acceso')->insert($data);
                }
                return redirect('katana/modulo/rebuild/'.$id->modulo_id);
            } else {
                return redirect('katana/modulo');
            }
        } else {
            return redirect('katana/modulo/create')
                ->with('message','The following errors occurred')->with('status','error')
                ->withErrors($validator)->withInput();
        }
    }

    function postPackage( Request $request)
    {
        if( count( $id = $request->input('id'))<1){
            return redirect('katana/modulo')->with('message','No se ha encontrado el modulo')->with('status','error');

        };

        $_id = array();
        foreach ( $id as $k => $v ){
            if( !is_numeric( $v )) continue;
            $_id[] = $v;
        }

        $ids = implode(',',$_id);

        $sql = "  
            SELECT * FROM tb_modulo 
            WHERE modulo_id IN (".$ids.") 
            ORDER by modulo_id 
            ";

        $rows = \DB::select($sql);

        $this->data['zip_content'] = array();
        $app_info = array();
        $inc_tables = array();

        foreach ( $rows as $k => $row ){

            $zip_content[] = array(
                'modulo_id'   =>  $row->modulo_id,
                'modulo_nombre' =>  $row->modulo_nombre,
                'modulo_db'   =>  $row->modulo_db,
                'modulo_type' =>  $row->modulo_type,
            );

        }

        // encrypt info
        $this->data['enc_module'] = base64_encode( serialize( $zip_content ));
        $this->data['enc_id'] = base64_encode( serialize( $id ));

        // module info
        $this->data['zip_content'] = $zip_content;

        /* CHANGE START HERE */
        $app_path = base_path();

        // file helper list
        $_path_inc = array( 'app/Library','resources/lang/en' );

        foreach( $_path_inc as $path){
            $file_inc[$path]  = scandir( $app_path .'/'. $path);
            foreach ( $file_inc[$path] as $k => $v ){
                if( $v=='.' || $v=='..') unset( $file_inc[$path][ $k ] );
                if( ! preg_match( '/.php$/i', $v )) unset( $file_inc[$path][ $k ] );
            }
        }


        $this->data['file_inc'] = $file_inc;

        /* CHANGE END HERE */

        return view('katana.modulo.package',$this->data);
    }

    function postDopackage( Request $request)
    {

        // app name
        $app_name     = $request->input('app_name');

        // encrypt info
        $enc_module   = $request->input('enc_module');
        $enc_id       = $request->input('enc_id');

        // query command || file
        $sql_cmd      = $request->input('sql_cmd');

        if( !( $_FILES['sql_cmd_upload']['error'])){
            $sql_path     = input::file('sql_cmd_upload')->getrealpath();
            if( $sql_content = file_get_contents( $sql_path )){
                $sql_cmd = $sql_content;
            }
        }

        /* CHANGE START */

        // file to include
        $file_library = $request->input('file_library');
        $file_lang    = $request->input('file_lang');

        /* CHANGE END */

        // create app name
        $tapp_code    = preg_replace('/([s[:punct:]]+)/',' ',$app_name);
        $app_code     = str_replace(' ','_', trim( $tapp_code ));

        $module_id    = unserialize( base64_decode( $enc_id ));
        $modules      = unserialize( base64_decode( $enc_module  ));
        $c_module_id  = implode( ',',$module_id );

        $zip_file ="./uploads/zip/{$app_code}.zip";

        $cf_zip = new \ZipHelpers;

        $app_path = app_path() ;

        $cf_zip->add_data( ".mysql" , $sql_cmd );

        // App ID Name
        $ain = $module_id;
        $cf_zip->add_data( ".ain", base64_encode( serialize($ain )));

        // setting
        $sql = " select * from tb_modulo where modulo_id in ( {$c_module_id} )";

        $_modules = \DB::select( $sql );

        foreach ( $_modules as $n => $_module ){
            $_modules[$n]->modulo_id = '';
        }

        $setting['tb_modulo'] = $_modules;

        $cf_zip->add_data( ".setting", base64_encode(serialize($setting)));

        unset( $_module );

        foreach ( $_modules as $n => $_module ){
            $file = $_module->modulo_nombre;
            $cf_zip->add_data( "app/Http/Controllers/". ucwords($file)."Controller.php",
                file_get_contents( $app_path."/Http/Controllers/". ucwords($file)."Controller.php")) ;
            $cf_zip->add_data( "app/Models/". ucwords($file).".php", file_get_contents($app_path."/Models/". ucwords($file).".php")) ;
            $cf_zip->get_files_from_folder( "../resources/views/{$file}/","resources/views/{$file}/" );

        }

        // CHANGE START

        // push library files
        if( ! empty( $file_library )){
            foreach ( $file_library as $k => $file ){
                $cf_zip->add_data( "app/Library/". $file ,
                    file_get_contents( $app_path."/Library/".$file)) ;
            }
        }

        // push language files

        if( ! empty ( $file_lang )){
            $lang_path = scandir( base_path() . '/resources/lang/' );
            foreach ( $lang_path as $k => $path ){
                if( $path=='.' || $path=='..') continue;
                if( is_file( $app_path . '/' . $path )) continue;

                foreach ( $file_lang as $k => $file ){
                    $cf_zip->add_data( 'resources/lang/'. $path .'/'. $file ,
                        file_get_contents( base_path()."/resources/lang/". $path . '/'. $file)) ;

                }
            }
            $this->data['lang_path'] = $lang_path;

        }


        // CHANGE END

        $_zip = $cf_zip->archive( $zip_file );

        $cf_zip->clear_data();

        $this->data['download_link'] = link_to("uploads/zip/{$app_name}.zip","download here",array('target'=>'_new'));

        $this->data['module_title'] = "ZIP Packager";
        $this->data['app_name'] = $app_name;

        return redirect( 'katana/modulo' )
            ->with('message', ' Module(s) zipped successful ! ')->with('status','success');
    }

    function postInstall( Request $request ,$id =0)
    {

        $rules = array(
            'installer'    => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $path = $_FILES['installer']['tmp_name'];
            $data = \KatanaHelpers::cf_unpackage($path);

            $msg = '.';
            if( isset($data['sql_error'])){
                $msg = ", with SQL error ". $data['sql_error'];
            }

            self::createRouters();

            return redirect('katana/modulo')->with('message','Module Installed' . $msg)->with('status','success');
        }  else  {
            return redirect('katana/modulo')->with('message','Please select file to upload !')->with('status','error');
        }

    }


    function postDobuild( Request $request ,$id )
    {

        $id = $request->input('modulo_id');
        $c = (isset($_POST['controlador']) ? 'y' : 'n');
        $m = (isset($_POST['modelo']) ? 'y' : 'n');
        $g = (isset($_POST['tabla']) ? 'y' : 'n');
        $f = (isset($_POST['formulario']) ? 'y' : 'n');
        $v = (isset($_POST['ver']) ? 'y' : 'n');
        $fg = (isset($_POST['fronttabla']) ? 'y' : 'n');
        $fv = (isset($_POST['frontver']) ? 'y' : 'n');
        $ff = (isset($_POST['frontform']) ? 'y' : 'n');

        //return redirect('')

        $url = 'katana/modulo/rebuild/'.$id."?rebuild=y&c={$c}&m={$m}&g={$g}&f={$f}&v={$v}&fg={$fg}&fv={$fv}&ff={$ff}";

        if(\Request::ajax() =='ajax')
        {
            return response()->json(array('status'=>'success','url'=> url($url)));

        } else {
            return redirect($url);
        }

    }

    public function getRebuild(Request $request, $id = 0)
    {

        $row = \DB::table('tb_modulo')->where('modulo_id', $id)->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','No se puede encontrar el módulo')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $class         = $row->modulo_nombre;
        $ctr = ucwords($row->modulo_nombre);
        $path         = $row->modulo_nombre;
        // build Field entry
        $f = '';
        $req = '';

        // End Build Fi global $codes;
        $codes = array(
            'controller'        => ucwords($class),
            'class'                => $class,
            'fields'            => $f,
            'required'            => $req,
            'table'                => $row->modulo_db ,
            'title'                => $row->modulo_titulo,
            'note'                => $row->modulo_nota ,
            'key'                => $row->modulo_db_key,
            'sql_select'                => $config['sql_select'],
            'sql_where'                    => $config['sql_where'],
            'sql_group'                    => $config['sql_group'],
        );

        if(!isset($config['form_layout']))
            $config['form_layout'] = array('column'=>1,'title'=>$row->modulo_titulo,'format'=>'grid','display'=>'horizontal');

        $codes['form_javascript'] = \SiteHelpers::toJavascript($config['forms'],$path,$class);
        $codes['form_entry'] = \SiteHelpers::toForm($config['forms'],$config['form_layout']);
        $codes['form_display'] = (isset($config['form_layout']['display']) ? $config['form_layout']['display'] : 'horizontal');
        $codes['form_view'] = \SiteHelpers::toView($config['grid']);
        // $codes['form_maps'] = \SiteHelpers::toMaps($config['grid']);

        $codes['masterdetailmodel']  = '';
        $codes['masterdetailinfo']   = '';
        $codes['masterdetailgrid']   = '';
        $codes['masterdetailsave']   = '';
        $codes['masterdetailform']   = '';
        $codes['masterdetailsubform']   = '';
        $codes['masterdetailview']   = '';
        $codes['masterdetailjs']   = '';
        $codes['masterdetaildelete']   = '';

        /* Subform */
        if(isset($config['subform']))
        {
            $md = \SiteHelpers::toMasterDetail($config['subform']);
            $codes['masterdetailmodel']  = $md['masterdetailmodel'] ;
            $codes['masterdetailinfo']   = $md['masterdetailinfo'] ;
            $codes['masterdetailsave']   = $md['masterdetailsave'] ;
            $codes['masterdetailsubform']   = $md['masterdetailsubform'] ;
            $codes['masterdetailform']   = $md['masterdetailform'] ;
            $codes['masterdetaildelete'] = $md['masterdetaildelete'];
            $codes['masterdetailjs']     = $md['masterdetailjs'] ;
        }


        /* End Master Detail */
        $dir = base_path().'/resources/views/'.$class;
        $dirPublic = base_path().'/resources/views/'.$class.'/public';
        $dirC = app_path().'/Http/Controllers/';
        $dirM = app_path().'/Models/';

        if(!is_dir($dir))               mkdir( $dir,0777 );
        if(!is_dir($dirPublic))         mkdir( $dirPublic,0777 );

        /* find type of module and generate it  */


        $mType = ( $row->modulo_type =='addon' ? 'native' :  $row->modulo_type);
        if(is_dir( base_path().'/resources/views/katana/modulo/template/'.$mType ))
        {
            require_once( base_path().'/resources/views/katana/modulo/template/'.$mType.'/config/config.php');
        }  else {

            if($request->ajax() == true && \Auth::check() == true)
            {
                return response()->json(array('status'=>'success','message'=>'La plantilla no existe'));
            } else {
                return redirect('katana/modulo')->with('message','La plantilla no existe')
                    ->with('status','success');
            }
        }
        self::createRouters();

        if($request->ajax() == true && \Auth::check() == true)
        {
            return response()->json(array('status'=>'success','message'=>'Los scripts han sido reemplazados correctamente'));
        } else {

            return redirect('katana/modulo')->with('message','Los scripts han sido reemplazados correctamente')->with('status','success');
        }
    }

    public function postFormdesign( Request $request)
    {

        $id = $request->input('modulo_id');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];

        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $data = $_POST['reordering'];
        $data = explode('|',$data);
        $currForm = $config['forms'];

        foreach($currForm as $f)
        {
            $cform[$f['field']] = $f;
        }

        $i = 0; $order = 0;
        $f = array();
        foreach($data as $dat)
        {

            $forms = explode(",",$dat);
            foreach($forms as $form)
            {
                if(isset($cform[$form]))
                {
                    $cform[$form]['form_group'] = $i;
                    $cform[$form]['sortlist'] = $order;
                    $f[] = $cform[$form];
                }
                $order++;
            }
            $i++;

        }

        $config['form_column'] = count($data);
        $config['form_layout'] = array(
            'column'    => count($data),
            'title' => implode(',',$request->input('title')) ,
            'format' => $request->input('format'),
            'display' => $request->input('display')

        );


        unset($config["forms"]);
        $new_config =     array_merge($config,array("forms" => $f));

        $data['modulo_config'] = \SiteHelpers::CF_encode_json($new_config);


        \DB::table('tb_modulo')
            ->where('modulo_id', '=',$id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($new_config)));

        return redirect('katana/modulo/formdesign/'.$row->modulo_nombre)
            ->with('message',' Forms Design Has Changed Successful.')->with('status','success');


    }

    public function postConn( Request $request )
    {
        $id = $request->input('modulo_id');
        $field_id     = $request->input('field_id');
        $alias         = $request->input('alias');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect($this->modulo)
                ->with('message', 'No se puede encontrar el módulo')->with('status','error');
        }
        $row = $row[0];

        $this->data['row'] = $row;
        $fr = array();
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        foreach($config['grid'] as $form)
        {
            if($form['field'] == $field_id && $form['alias'] == $alias )
            {
                if($request->input('db') !='')
                {
                    $value = implode("|",$request->input('display'));
                    $form['conn'] = array(
                        'valid'        => '1',
                        'db'        => $request->input('db'),
                        'key'        => $request->input('key'),
                        'display'    => implode("|",array_filter($request->input('display'))),
                    );
                } else {

                    $form['conn'] = array(
                        'valid'        => '0',
                        'db'        => '',
                        'key'        => '',
                        'display'    => '',
                    );

                }
                $fr[] =  $form;
            }    else {
                $fr[] =  $form;
            }
        }
        unset($config["grid"]);
        $new_config =     array_merge($config,array("grid" => $fr));


        $affected = \DB::table('tb_modulo')
            ->where('modulo_id', '=',$id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($new_config)));

        return redirect('katana/modulo/table/'.$row->modulo_nombre)
            ->with('message','Los campos del módulo se han cambiados correctamente.')->with('status','success');
    }

    function getTable( $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $fp = base_path().'/resources/views/katana/modulo/template/'.$this->getTemplateName($row->modulo_type).'/config/info.json';
        $fp = json_decode(file_get_contents($fp));
        $this->data['config'] = $fp;

        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $this->data['tables']     = $config['grid'];

        $this->data['module'] = 'modulo';
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $this->data['type']     = ($row->modulo_type =='ajax' ? 'addon' : $row->modulo_type);
        return view('katana.modulo.table',$this->data);
    }

    function getForm( $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        // Get config Info
        $fp = base_path().'/resources/views/katana/modulo/template/'.$this->getTemplateName($row->modulo_type).'/config/info.json';
        $fp = json_decode(file_get_contents($fp));
        $this->data['config'] = $fp;

        $this->data['forms']     = $config['forms'];
        $this->data['form_column'] = (isset($config['form_column']) ? $config['form_column'] : 1 );
        $this->data['modulo'] = 'modulo';
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $this->data['type']     = ($row->modulo_type =='ajax' ? 'addon' : $row->modulo_type);
        return view('katana.modulo.form',$this->data);
    }

    public function postSaveform( Request $request)
    {
        $id = $request->input('modulo_id');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];

        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $lang = \SiteHelpers::langOption();
        $this->data['tables']     = $config['grid'];
        $total = count($_POST['field']);
        extract($_POST);
        $f = array();
        for($i=1; $i<= $total ;$i++) {
            $language =array();
            foreach($lang as $l)
            {
                if($l['folder'] !='es'){
                    $label_lang = (isset($_POST['language'][$i][$l['folder']]) ? $_POST['language'][$i][$l['folder']] : '');
                    $language[$l['folder']] =$label_lang;
                }
            }
            $f[] = array(
                "field"         => $field[$i],
                "alias"         => $alias[$i],
                "language"         => $language,
                "label"         => $label[$i],
                'form_group'    => $form_group[$i],
                'required'        => (isset($required[$i]) ? $required[$i] : 0 ),
                'view'            => (isset($view[$i]) ? 1 : 0 ),
                'type'            => $type[$i],
                'add'            => 1,
                'size'            => '0',
                'edit'            => 1,
                'search'        => (isset($search[$i]) ? $search[$i] : 0 ),
                "sortlist"         => $sortlist[$i] ,
                'limited'    => (isset($limited[$i]) ? $limited[$i] : ''),
                'option'        => array(
                    "opt_type"                 => $opt_type[$i],
                    "lookup_query"             => $lookup_query[$i],
                    "lookup_table"             => $lookup_table[$i],
                    "lookup_key"             => $lookup_key[$i],
                    "lookup_value"            => $lookup_value[$i],
                    'is_dependency'            => $is_dependency[$i],
                    'select_multiple'            => (isset($select_multiple[$i]) ? $select_multiple[$i] : 0),
                    'image_multiple'            => (isset($image_multiple[$i]) ? $image_multiple[$i] : 0),
                    'lookup_dependency_key'    => $lookup_dependency_key[$i],
                    'path_to_upload'        => $path_to_upload[$i],
                    'resize_width'            => $resize_width[$i],
                    'resize_height'            => $resize_height[$i],
                    'upload_type'            => $upload_type[$i],
                    'tooltip'                => $tooltip[$i],
                    'attribute'                => $attribute[$i],
                    'extend_class'            => $extend_class[$i]
                ),
            );
        }

        unset($config["forms"]);
        $new_config =     array_merge($config,array("forms" => $f));
        $data['modulo_config'] = \SiteHelpers::CF_encode_json($new_config);

        \DB::table('tb_modulo')
            ->where('modulo_id', '=',$id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($new_config)));

        if($request->ajax() == true)
        {
            return response()->json(array('status'=>'success','message'=>'Module Forms Has Changed Successful'));
        } else {

            return redirect('katana/modulo/form/'.$row->modulo_nombre)
                ->with('message','Module Forms Has Changed Successful.')->with('status','success');
        }
    }

    function postSaveformfield( Request $request)
    {
        $lookup_value = (is_array($request->input('lookup_value')) ? implode("|",array_filter($request->input('lookup_value'))) : '');
        $id = $request->input('modulo_id');
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','No se encuentra el modulo')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);

        $view = 0;$search = 0;
        if(!is_null($request->input('view'))) $view = 1;
        if(!is_null($request->input('search'))) $search = 1;

        if(preg_match('/(select|radio|checkbox)/',$request->input('type')))
        {
            if($request->input('opt_type') == 'datalist')
            {
                $datalist = '';
                $cf_val     = $request->input('custom_field_val');
                $cf_display = $request->input('custom_field_display');
                for($i=0; $i<count($cf_val);$i++)
                {
                    $value         = $cf_val[$i];
                    if(isset($cf_display[$i])) { $display = $cf_display[$i]; } else { $display ='none';}
                    $datalist .= $value.':'.$display.'|';
                }
                $datalist = substr($datalist,0,strlen($datalist)-1);

            } else {
                $datalist = '';
            }
        }  else {
            $datalist = '';
        }

        $new_field = array(
            "field"         => $request->input('field'),
            "alias"         => $request->input('alias'),
            "label"         => $request->input('label'),
            "form_group"     => $request->input('form_group'),
            'required'        => $request->input('required'),
            'view'            => $view,
            'type'            => $request->input('type'),
            'add'            => 1,
            'edit'            => 1,
            'search'        => $request->input('search'),
            'size'            =>     '',
            'sortlist'        => $request->input('sortlist'),
            'limited'           => $request->input('limited'),
            'option'        => array(
                "opt_type"         =>  $request->input('opt_type'),
                "lookup_query"     =>  $datalist,
                "lookup_table"     =>  $request->input('lookup_table'),
                "lookup_key"     =>  $request->input('lookup_key'),
                "lookup_value"    =>     $lookup_value,
                'is_dependency'    =>  $request->input('is_dependency'),
                'select_multiple'    =>  (!is_null($request->input('select_multiple')) ? '1':'0'),
                'image_multiple'    =>  (!is_null($request->input('image_multiple')) ? '1':'0'),
                'lookup_dependency_key'=>  $request->input('lookup_dependency_key'),
                'path_to_upload'=>  $request->input('path_to_upload'),
                'upload_type'    =>  $request->input('upload_type'),
                'resize_width'    =>  $request->input('resize_width'),
                'resize_height'    =>  $request->input('resize_height'),
                'tooltip'        =>  $request->input('tooltip'),
                'attribute'        =>  $request->input('attribute'),
                'extend_class'    =>  $request->input('extend_class'),
                'prefix'                => $request->input('prefix'),
                'sufix'                => $request->input('sufix')
            )
        );

        $forms = array();
        foreach($config['forms'] as $form_view)
        {
            if($form_view['field'] == $request->input('field') && $form_view['alias'] == $request->input('alias') )
            {
                $new_form = $new_field;
            } else     {
                $new_form  = $form_view;
            }
            $forms[] = $new_form ;

        }


        unset($config["forms"]);
        $new_config =     array_merge($config,array("forms" => $forms));


        \DB::table('tb_modulo')
            ->where('modulo_id', '=',$id )
            ->update(array('modulo_config' => \SiteHelpers::CF_encode_json($new_config)));

        return redirect('katana/modulo/form/'.$row->modulo_nombre)
            ->with('message','Forms Has Changed Successful.')->with('status','success');
    }

    public function getEditform(Request $request, $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);

        $module_id = $id;
        $field_id     = $request->input('field');
        $alias         = $request->input('alias');

        $f = array();
        foreach( $config['forms'] as $form )
        {
            $tooltip = '';$attribute = '';
            if(isset($form['option']['tooltip'])) $tooltip = $form['option']['tooltip'];
            if(isset($form['option']['attribute'])) $attribute = $form['option']['attribute'];
            $size = isset($form['size']) ? $form['size'] : 'span12';
            if($form['field'] == $field_id && $form['alias'] == $alias)
            {
                //$multiVal = explode(":",$form['option']['lookup_value']);
                $f = array(
                    "field"     => $form['field'],
                    "alias"     => $form['alias'],
                    "label"     =>  $form['label'],
                    'form_group'    =>  $form['form_group'],
                    'required'        => $form['required'],
                    'view'            => $form['view'],
                    'type'            => $form['type'],
                    'add'            => $form['add'],
                    'size'            => $size,
                    'edit'            => $form['edit'],
                    'search'        => $form['search'],
                    "sortlist"         => $form['sortlist'] ,
                    'limited'           => isset($form['limited']) ? $form['limited'] : '',
                    'option'        => array(
                        "opt_type"                 => $form['option']['opt_type'],
                        "lookup_query"             => $form['option']['lookup_query'],
                        "lookup_table"             => $form['option']['lookup_table'],
                        "lookup_key"             => $form['option']['lookup_key'],
                        "lookup_value"            => $form['option']['lookup_value'],
                        'is_dependency'            => $form['option']['is_dependency'],
                        'select_multiple'            => (isset($form['option']['select_multiple']) ? $form['option']['select_multiple'] : 0 ) ,
                        'image_multiple'            => (isset($form['option']['image_multiple']) ? $form['option']['image_multiple'] : 0 ) ,
                        'lookup_dependency_key'    => $form['option']['lookup_dependency_key'],
                        'path_to_upload'        => $form['option']['path_to_upload'],
                        'upload_type'            => $form['option']['upload_type'],
                        'resize_width'            => isset( $form['option']['resize_width'])?$form['option']['resize_width']:'' ,
                        'resize_height'            => isset( $form['option']['resize_height'])? $form['option']['resize_height']:'',
                        'extend_class'            => isset( $form['option']['extend_class'])?$form['option']['extend_class']:'',
                        'tooltip'                => $tooltip ,
                        'attribute'                => $attribute,
                        'extend_class'            => isset( $form['option']['extend_class'])?$form['option']['extend_class']:'',
                        'prefix'            => isset( $form['option']['prefix'])?$form['option']['prefix']:'' ,
                        'sufix'            => isset( $form['option']['sufix'])?$form['option']['sufix']:''
                    ),
                );
            }
        }


        $this->data['field_type_opt'] = array(
            'hidden'        => 'Hidden',
            'text'            => 'Text' ,
            'text_date'        => 'Date',
            'text_datetime'        => 'Date & Time',
            'textarea'        => 'Textarea',
            'textarea_editor'    => 'Textarea With Editor ',
            'select'        => 'Select Option',
            'radio'            => 'Radio' ,
            'checkbox'        => 'Checkbox',
            'file'            => 'Upload File',
            'color'        => 'Color Picker',
            'maps'        => 'Google Maps',

        );

        $this->data['tables']        = Modulo::getTableList($this->db);
        $this->data['f']     = $f;
        $this->data['modulo_id']     = $id;

        $this->data['modulo'] = 'module';
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        return view('katana.modulo.field',$this->data);
    }

    function getDestroy( $id = null )
    {
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','No se encuentra el modulo')->with('status','error');

        }
        $row = $row[0];
        $path = $row->modulo_nombre;
        $class = ucwords($row->modulo_nombre);

        if($row->modulo_type !='core')
        {

            if($class !='') {

                \DB::table('tb_modulo')->where('modulo_id','=',$row->modulo_id)->delete();
                \DB::table('tb_grupos_acceso')->where('modulo_id','=',$row->modulo_id)->delete();
                self::createRouters();


                if(file_exists(  app_path()."/Http/Controllers/{$class}Controller.php"))
                    unlink( app_path()."/Http/Controllers/{$class}Controller.php");

                if(file_exists( app_path()."/Models/{$class}.php"))
                    unlink( app_path()."/Models/{$class}.php");

                self::removeDir( base_path()."/resources/views/{$path}");

                return redirect('katana/modulo')
                    ->with('message','El modulo ha sido eliminado Correctamente')->with('status','success');

            }

        }
        return redirect($this->module)
            ->with('message', 'No se puede eliminar el Módulo  !')->with('status','success');
    }


    function getConn( Request $request , $id )
    {
        $row = \DB::table('tb_modulo')->where('modulo_id', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);

        $module_id = $id;
        $field_id     = $request->input('field');
        $alias         = $request->input('alias');
        $f = array();
        foreach($config['grid'] as $form)
        {
            if($form['field'] == $field_id)
            {

                $f = array(
                    'db'        => (isset($form['conn']['db']) ? $form['conn']['db'] : ''),
                    'key'        => (isset($form['conn']['key']) ? $form['conn']['key'] : ''),
                    'display'    => (isset($form['conn']['display']) ? $form['conn']['display'] : ''),
                );
            }
        }

        $this->data['modulo_id']     = $id;
        $this->data['f']     = $f;
        $this->data['modulo'] = 'module';
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $this->data['field_id'] = $field_id ;
        $this->data['alias'] = $alias;
        return view('katana.modulo.connection',$this->data);
    }

    function getSubform( Request $request ,$id =0)
    {
        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $this->data['row'] = $row;
        $this->data['fields'] = $config['grid'];
        $this->data['subform'] = (isset($config['subform']) ? $config['subform'] : array());
//          print_r($this->data['subform']);
        $this->data['tables'] = Modulo::getTableList($this->db);
        $this->data['modulo'] = $row->modulo_nombre;
        $this->data['modulo_nombre'] = $id;
        $this->data['type']           = $row->modulo_type;
        $this->data['modulos'] = Modulo::all();
        return view('katana.modulo.subform',$this->data);
    }

    function getTemplateName( $file ) {
        if($file =='addon' or $file =='core') {
            return 'native';
        } else  {
            return $file;
        }
    }

    function getFormdesign( Request $request , $id)
    {
        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect($this->modulo)
                ->with('message', 'No se puede encontrar el módulo')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $this->data['forms']     = $config['forms'];
        $this->data['module'] = 'module';
        $this->data['form_column'] = (isset($config['form_column']) ? $config['form_column'] : 1 );
        if(!is_null($request->input('block')))     $this->data['form_column'] = $request->input('block');

        if(!isset($config['form_layout']))
        {
            $this->data['title'] = array($row->modulo_nombre);
            $this->data['format'] = 'grid';
            $this->data['display'] = 'horizontal';


        } else {
            $this->data['title']     =    explode(",",$config['form_layout']['title']);
            $this->data['format']     =    $config['form_layout']['format'];
            $this->data['display']     =    (isset($config['form_layout']['display']) ? $config['form_layout']['display']: 'horizontal');
        }
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $this->data['type']           = $row->modulo_type;
        return view('katana.modulo.formdesign',$this->data);
    }

    function getPermission( $id )
    {

        $row = \DB::table('tb_modulo')->where('modulo_nombre', $id)
            ->get();
        if(count($row) <= 0){
            return redirect('katana/modulo')->with('message','Can not find module')->with('status','error');
        }
        $row = $row[0];
        $this->data['row'] = $row;
        // Get config Info
        $fp = base_path().'/resources/views/katana/modulo/template/'.$this->getTemplateName($row->modulo_type).'/config/info.json';
        $fp = json_decode(file_get_contents($fp),true);
        $this->data['config'] = $fp;
        $this->data['modulo'] = 'modulo';
        $this->data['modulo_nombre'] = $row->modulo_nombre;
        $config = \SiteHelpers::CF_decode_json($row->modulo_config);
        $this->data['type']     = $row->modulo_type;

        $tasks = $fp['access'];
        /* Update permission global / own access new ver 1.1
           Adding new param is_global
           End Update permission global / own access new ver 1.1
        */
        if(isset($config['tasks'])) {
            foreach($config['tasks'] as $row)
            {
                $tasks[$row['item']] = $row['title'];
            }
        }
        $this->data['tasks'] = $tasks;
        $this->data['grupos'] = \DB::table('tb_grupos')->get();

        $access = array();
        foreach($this->data['grupos'] as $r)
        {
            //    $GA = $this->model->gAccessss($this->uri->rsegment(3),$row['group_id']);
            $group = ($r->grupo_id !=null ? "and grupo_id ='".$r->grupo_id."'" : "" );
            $GA = \DB::select("SELECT * FROM tb_grupos_acceso where modulo_id ='".$row->modulo_id."' $group");
            if(count($GA) >=1){
                $GA = $GA[0];
            }

            $access_data = (isset($GA->datos_acceso ) ? json_decode($GA->datos_acceso,true) : array());

            $rows = array();
            //$access_data = json_decode($AD,true);
            $rows['grupo_id'] = $r->grupo_id;
            $rows['grupo_codigo'] = $r->codigo;
            foreach($tasks as $item=>$val)
            {
                $rows[$item] = (isset($access_data[$item]) && $access_data[$item] ==1  ? 1 : 0);
            }
            $access[$r->codigo] = $rows;


        }
        $this->data['access'] = $access;
        $this->data['groups_access'] = \DB::select("select * from tb_grupos_acceso where modulo_id ='".$row->modulo_id."'");
        $this->data['type']     = ($row->modulo_type =='ajax' ? 'addon' : $row->modulo_type);
        return view('katana.modulo.permission',$this->data);
    }

    public function getCombotable( Request $request)
    {
        if($request->ajax() == true && \Auth::check() == true)
        {
            $rows = Modulo::getTableList($this->db);
            $items = array();
            foreach($rows as $row) $items[] = array($row , $row);
            return json_encode($items);
        } else {
            return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
        }
    }

    public function getCombotablefield( Request $request)
    {
        if($request->input('table') =='') return json_encode(array());
        if($request->ajax() == true && \Auth::check() == true)
        {
            $items = array();
            $table = $request->input('table');
            if($table !='')
            {
                $rows = Modulo::getTableField($request->input('table'));
                foreach($rows as $row)
                    $items[] = array($row , $row);
            }
            return json_encode($items);
        } else {
            return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
        }
    }

    function configGrid ( $field , $alias , $type, $sort ) {
        $grid = array (
            "field"     => $field,
            "alias"     => $alias,
            "label"     => ucwords(str_replace('_',' ',$field)),
            "language"    => array(),
            "search"     => '1' ,
            "download"     => '1' ,
            "align"     => 'left' ,
            "view"         => '1' ,
            "detail"      => '1',
            "sortable"     => '1',
            "frozen"     => '0',
            "sortlist"     => $sort ,
            "width"     => '100',
            "conn"          => array('valid'=>'0','db'=>'','key'=>'','display'=>''),
            "format_as"     =>'',
            "format_value"  =>'',

        );
        return $grid;

    }

    function findPrimarykey( $table )
    {
        //  show columns from members where extra like '%auto_increment%'"
//        $query = "SHOW columns FROM `{$table}` WHERE extra LIKE '%auto_increment%'";
        $query = "SELECT B.COLUMN_NAME as Field
                  FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS A, INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE B
                  WHERE CONSTRAINT_TYPE = 'PRIMARY KEY' AND A.CONSTRAINT_NAME = B.CONSTRAINT_NAME
                  and A.TABLE_NAME = '{$table}'";
        $primaryKey = '';
        foreach(\DB::select($query) as $key)
        {
            $primaryKey = $key->Field;
            // print_r($key);
        }
        return $primaryKey;
    }

    function configForm( $field , $alias, $type , $sort, $opt = array()) {

        $opt_type = ''; $lookup_table =''; $lookup_key ='';
        if(count($opt) >=1) {
            $opt_type = $opt[0]; $lookup_table = $opt[1]; $lookup_key = $opt[2];
        }

        $forms = array(
            "field"     => $field,
            "alias"     => $alias,
            "label"     => ucwords(str_replace('_',' ',$field)),
            "language"    => array(),
            'required'        => '0',
            'view'            => '1',
            'type'            => self::configFieldType($type),
            'add'            => '1',
            'edit'            => '1',
            'search'        => '1',

            'size'            => 'span12',
            "sortlist"     => $sort ,
            'form_group'    => '',
            'option'        => array(
                "opt_type"                 => $opt_type,
                "lookup_query"             => '',
                "lookup_table"             =>     $lookup_table,
                "lookup_key"             =>  $lookup_key,
                "lookup_value"            => $lookup_key,
                'is_dependency'            => '',
                'select_multiple'            => '0',
                'image_multiple'            => '0',
                'lookup_dependency_key'    => '',
                'path_to_upload'        => '',
                'upload_type'        => '',
                'tooltip'        => '',
                'attribute'        => '',
                'extend_class'        => ''
            )
        );
        return $forms;

    }


    function configFieldType( $type )
    {
        switch($type)
        {
            default: $type = 'text'; break;
            case 'timestamp'; $type = 'text_datetime'; break;
            case 'datetime'; $type = 'text_datetime'; break;
            case 'string'; $type = 'text'; break;
            case 'int'; $type = 'text'; break;
            case 'text'; $type = 'textarea'; break;
            case 'blob'; $type = 'textarea'; break;
            case 'select'; $type = 'select'; break;
        }
        return $type;
    }

    function buildRelation( $table , $field)
    {
        $pdo = \DB::getPdo();
        $sql = "SELECT o1.name  as 'table', c1.name  as 'column'
                FROM sys.objects o1
                INNER JOIN sys.foreign_keys fk ON o1.object_id = fk.parent_object_id
                INNER JOIN sys.foreign_key_columns fkc ON fk.object_id = fkc.constraint_object_id
                INNER JOIN sys.columns c1 ON fkc.parent_object_id = c1.object_id AND fkc.parent_column_id = c1.column_id
                WHERE o1.name = '{$table}'
                AND c1.name = '{$field}'";
        $Q = $pdo->query($sql);
        $rows = array();
        while ($row =  $Q->fetch()) {
            $rows[] = $row;
        }
        return $rows;
    }

    function createRouters()
    {
        $rows = \DB::table('tb_modulo')->where('modulo_type','!=','core')->get();
        $val  =    "<?php
        ";
        foreach($rows as $row)
        {
            $class = $row->modulo_nombre;
            $controller = ucwords($row->modulo_nombre).'Controller';

            $mType = ( $row->modulo_type =='addon' ? 'native' :  $row->modulo_type);
            include(base_path().'/resources/views/katana/modulo/template/'.$row->modulo_type.'/config/route.php' );
        }
        $val .=     "?>";
        $filename = base_path().'/routes/module.php';
        $fp=fopen($filename,"w+");
        fwrite($fp,$val);
        fclose($fp);
        return true;
    }
}
