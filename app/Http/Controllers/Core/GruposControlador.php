<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\Core\Grupos;
use Illuminate\Http\Request;
use Validator, Input, Redirect ;

class GruposControlador extends Controller
{
    protected $layout = "layouts.main";
    protected $data = array();
    public $modulo = 'grupos';
    static $per_page	= '10';

    public function __construct() {
        parent::__construct();
        $this->model = new Grupos();
        $this->info = $this->model->makeInfo( $this->modulo);
        $this->data = array(
            'pageTitle'	=> 	$this->info['title'],
            'pageNote'	=>  $this->info['note'],
            'pageModule'=> 'core/grupos',
            'return'	=> self::returnUrl()

        );
    }

    public function index( Request $request) {
        // Make Sure users Logged
        if(!\Auth::check())
            return redirect('/login')->with('status', 'error')->with('message','You are not login');
        $this->grab( $request) ;
        if($this->access['is_view'] ==0)
            return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');
        // Render into template
        return view( 'core.'. $this->modulo.'.index',$this->data);
    }

    function create( Request $request )
    {
        $this->hook( $request  );

        if($this->access['is_add'] ==0)
            return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

        $this->data['row'] = $this->model->getColumnTable( $this->info['table']);
        $this->data['id'] = '';
        return view( 'core.'. $this->modulo.'.form',$this->data);
    }
    function store( Request $request  )
    {
        $task = $request->input('action_task');
        switch ($task)
        {
            default:
                $rules = $this->validateForm();
                $validator = Validator::make($request->all(), $rules);
                if ($validator->passes())
                {
                    $data = $this->validatePost( $request );
                    if(isset($data['grupo_id'])) unset($data['grupo_id']);
                    $id = $this->model->insertRow($data , $request->input( $this->info['key']));

                    /* Insert logs */
                    $this->model->logs($request , $id);
                    if(!is_null($request->input('apply')))
                        return redirect( 'core/'. $this->modulo .'/'.$id.'/edit?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

                    return redirect( 'core/'.$this->modulo .'?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
                }
                else {
                    return redirect('core/'.$this->modulo.'/'. $request->input(  $this->info['key'] ))
                        ->with('message',__('core.note_error'))->with('status','error')
                        ->withErrors($validator)->withInput();

                }
                break;
            case 'delete':
                $result = $this->destroy( $request );
                return redirect('core/'.$this->modulo.'?'.$this->returnUrl())->with($result);
                break;

            case 'import':
                return $this->PostImport( $request );
                break;

            case 'copy':
                $result = $this->copy( $request );
                return redirect('core/'.$this->modulo.'?'.$this->returnUrl())->with($result);
                break;
        }

    }
    function edit( Request $request , $id )
    {
        $this->hook( $request , $id );
        if(!isset($this->data['row']))
            return redirect($this->modulo)->with('message','Registro no encontrado !')->with('status','error');

        if($this->access['is_edit'] ==0 )
            return redirect('dashboard')->with('message',__('core.note_restric'))->with('status','error');


        $this->data['row'] = (array) $this->data['row'];
        $this->data['id'] = $id;
        return view( 'core.'. $this->modulo.'.form',$this->data);
    }
}
