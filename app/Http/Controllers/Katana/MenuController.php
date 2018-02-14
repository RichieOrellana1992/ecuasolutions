<?php namespace App\Http\Controllers\katana;

use App\Models\katana\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 



class MenuController extends Controller {

	public function __construct()
	{
		parent::__construct();
        $this->middleware(function ($request, $next) {           
            if(session('gid') !='1')
                return redirect('dashboard')
                ->with('message','You Dont Have Access to Page !')->with('status','error');            
            return $next($request);
        });		
		$this->model = new Menu();
		$this->info = $this->model->makeInfo( 'menu');
		$this->access = $this->model->validAccess($this->info['id'] );


        $this->data = array_merge(array(
            'pageTitle' =>  'Navegación',
            'pageNote'  =>  'Administrar el menu lateral / superior',
            
        ),$this->data)  ;		
	}


	public function getIndex( Request $request ,$id = null  )
	{
		$pos = (!is_null($request->input('pos')) ? $request->input('pos') : 'top' );
		$row = \DB::table('tb_menu')->where('menu_id',$id)->get();
		if(count($row)>=1)
		{
			
			$rows = $row[0];
			$this->data['row']=(array)$rows;


			$this->data['menu_lang'] = json_decode($rows->menu_lang,true);    
		} else {
			$this->data['row'] = array(
					'menu_id'	=> '',
					'padre_id'	=> '',
					'menu_nombre'	=> '',
					'menu_tipo'	=> '',
					'url'	=> '',
					'modulo'	=> '',
					'posicion'	=> '',
					'menu_iconos'	=> '',
					'activo'	=> '',
					'datos_acceso'	=> '',

				); 
			$this->data['menu_lang'] = array(); 
		}
		//echo '<pre>';print_r($this->data);echo '</pre>';  exit;
		$this->data['menus']		= \SiteHelpers::menus( $pos ,'all');
		$this->data['modulos'] 		= \DB::table('tb_modulo')->where('modulo_type','!=','core')->get();
		$this->data['grupos'] 		= \DB::select(" SELECT * FROM tb_grupos");
//		$this->data['pages'] 		= \DB::select(" SELECT * FROM tb_pages WHERE  pagetype != 'post' OR pagetype IS NULL ");
		$this->data['activo'] 		= $pos;
		return view('katana.menu.index',$this->data);
	}

	function postSaveorder( Request $request, $id =0)
	{

		$rules = array(
			'reorder'	=> 'required'
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$menus = json_decode($request->input('reorder'),true);

			
			$child = array();
			$a=0;
			foreach($menus as $m)
			{			
				if(isset($m['children']))
				{
					$b=0;
					foreach($m['children'] as $l)					
					{
						if(isset($l['children']))
						{
							$c=0;
							foreach($l['children'] as $l2)
							{
								$level3[] = $l2['id'];
								\DB::table('tb_menu')->where('menu_id','=',$l2['id'])
									->update(array('padre_id'=> $l['id'],'orden'=>$c));
								$c++;	
							}		
						}
						\DB::table('tb_menu')->where('menu_id','=', $l['id'])
							->update(array('padre_id'=> $m['id'],'orden'=>$b));
						$b++;
					}							
				}
				\DB::table('tb_menu')->where('menu_id','=', $m['id'])
					->update(array('padre_id'=>'0','orden'=>$a));
				$a++;		
			}
			return redirect('katana/menu')
				->with('message', 'Data Has Been Save Successfull')->with('status','success');
		} else {
			return redirect('katana/menu')
				->with('message', 'The following errors occurred')->with('status','error');

		}	

	
	}
	
	function postSave( Request $request, $id =0)
	{
		

		$rules = array(
			'menu_nombre'	=> 'required',
			'activo'	=> 'required',
			'menu_tipo'	=> 'required',
			'posicion'	=> 'required',
		);
		$validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $pos = $request->input('posicion');
            $data = $this->validatePost( $request );


            if($this->config['cnf_multilang'] ==1)
			{
				$lang = \SiteHelpers::langOption();
				$language =array();
				foreach($lang as $l)
				{
					if($l['folder'] !='es'){
						$menu_lang = (isset($_POST['language_title'][$l['folder']]) ? $_POST['language_title'][$l['folder']] : '');  
						$language['title'][$l['folder']] = $menu_lang;        
					}    
				}	
					
				$data['menu_lang'] = json_encode($language);  
			}			
			
			$arr = array();
			$grupos = \DB::table('tb_grupos')->get();

			foreach($grupos as $g)
			{
				$arr[$g->grupo_id] = (isset($_POST['grupos'][$g->grupo_id]) ? "1" : "0" );
			}
			$data['datos_acceso'] = json_encode($arr);
			if(isset($data['menu_id'])) unset($data['menu_id']);
			$this->model->insertRow($data , $request->input('menu_id'));
			
			return redirect('katana/menu?pos='.$pos)
				->with('message', 'Data Has Been Save Successfull')->with('status','success');

		} else {
			return redirect('katana/menu?pos='.$pos)
				->with('message', 'The following errors occurred')->with('status','error')->withErrors($validator)->withInput();

		}	
	
	}
	
	public function getDestroy(Request $request,$id)
	{
		// delete multipe rows 
		
		$menus = \DB::table('tb_menu')->where('padre_id','=',$id)->get();
		foreach($menus as $row)
		{
			$this->model->destroy($row->menu_id);
		}
		
		$this->model->destroy($id);
		return redirect('katana/menu?pos='.$request->input('pos'))
				->with('message', 'Successfully deleted row!')->with('status','success');

	}						

	public function getIcons( Request $request ,$id = null  )
	{
		return view('katana.menu.icons');

	}

}