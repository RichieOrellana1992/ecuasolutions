<?php

namespace App\Http\Controllers;

use App\User;
use App\Libary\SiteHelpers;
use Socialize;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;

class UserController extends Controller
{
    protected $layout = "layouts.main";

    public function __construct() {
        parent::__construct();
        $this->data = array();
    }

    public function getLogin() {
        if(\Auth::check())
        {
            return redirect('')->with(['message'=>'success','Youre already login','status'=>'success']);

        } else {
            $this->data['socialize'] =  config('services');
            return View('usuarios.login',$this->data);

        }
    }

    public function postSignin( Request $request) {

        $rules = array(
            'email'=>'required',
            'password'=>'required',
        );
        if(config('ktn.cnf_recaptcha') =='true') {
            $return = $this->reCaptcha($request->all());
            if($return !== false)
            {
                if($return['success'] !='true')
                {
                    return response()->json(['status' => $return['success'], 'message' =>'Invalid reCpatcha']);
                }

            }
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $remember = (!is_null($request->get('remember')) ? 'true' : 'false' );

            if (\Auth::attempt(array('email'=>$request->input('email'), 'password'=> $request->input('password') ), $remember )
                or
                \Auth::attempt(array('username'=>$request->input('email'), 'password'=> $request->input('password') ), $remember )
                ) {

                if(\Auth::check())
                {
                    $row = User::find(\Auth::user()->id);
                    if($row->activo =='Inactive')
                    {
                        // inactive
                        if($request->ajax() == true )
                        {
                            return response()->json(['status' => 'error', 'message' => 'Your Account is not active']);
                        } else {
                            \Auth::logout();
                            return redirect('/login')->with(['status' => 'error', 'message' => 'Your Account is not active']);
                        }

                    } else if($row->activo=='Banned')
                    {

                        if($request->ajax() == true )
                        {
                            return response()->json(['status' => 'error', 'message' => 'Your Account is BLocked']);
                        } else {
                            // BLocked users
                            \Auth::logout();
                            return redirect('/login')->with(['status' => 'error', 'message' => 'Your Account is BLocked']);
                        }
                    } else {
                        \DB::table('tb_usuarios')->where('username', '=',$row->username )->update(array('ultimo_login' => date("Y-d-m H:i:s")));
                        $level = 99;
                        $sql = \DB::table('tb_grupos')->where('grupo_id' , $row->grupo_id )->get();
                        if(count($sql))
                        {
                            $l = $sql[0];
                            $level = $l->nivel ;
                        }

                        $session = array(
                            'gid' => $row->grupo_id,
                            'uid' => $row->id,
                            'eid' => $row->email,
                            'll' => $row->ultimo_login,
                            'fid' =>  $row->nombre.' '. $row->apellido,
                            'username' =>  $row->username,
                            'join'	=>  $row->created_at ,
                            'level'	=> $level
                        );
                        /* Set Lang if available */
                        if(!is_null($request->input('language')))
                        {
                            $session['lang'] = $request->input('language');
                        } else {
                            $session['lang'] = config('ktn.cnf_lang');

                        }


                        session($session);
                        if($request->ajax() == true )
                        {
                            if( config('ktn.cnf_front') =='false') :
                                return response()->json(['status' => 'success', 'url' => url('dashboard')]);
                            else :
                                return response()->json(['status' => 'success', 'url' => url('')]);
                            endif;

                        }
                        else {
                            if( config('ktn.cnf_front') =='false') :
                                return redirect('dashboard');
                            else :
                                return redirect('');
                            endif;
                        }
                    }
                }
            }
            else {

                if($request->ajax() == true )
                {
                    return response()->json(['status' => 'error', 'message' => 'Su combinación de nombre de usuario / contraseña fue incorrecta.']);
                } else {

                    return redirect('login')
                        ->with(['status' => 'error', 'message' => 'Su combinación de nombre de usuario / contraseña fue incorrecta.'])
                        ->withInput();
                }
            }
        }
        else {

            if($request->ajax() == true)
            {
                return response()->json(['status' => 'error', 'message' => 'Se encontraron los siguientes errores.']);
            } else {

                return redirect('/login')
                    ->with(['status' => 'error', 'message' => 'Se encontraron los siguientes errores.'])
                    ->withErrors($validator)->withInput();
            }

        }
    }

    public function reCaptcha( $request)
    {
        if(!is_null($request['g-recaptcha-response']))
        {
            $api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . config('ktn.cnf_recaptchaprivatekey') . '&response='.$request['g-recaptcha-response'];
            $response = @file_get_contents($api_url);
            $data = json_decode($response, true);

            return $data;
        }
        else
        {
            return false ;
        }
    }

    public function getLogout() {
        \Auth::logout();
        \Session::flush();
        return redirect('')->with(['message'=>'Your are now logged out!','status'=>'success']);
    }
}
