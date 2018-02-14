<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        parent::__construct();

        $this->data['pageLang'] = 'en';
        if(\Session::get('lang') != '')
        {
            $this->data['pageLang'] = \Session::get('lang');
        }
    }
    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */

    public function index( Request $request)
    {
        return redirect('/login');
    }

    public function set_theme( $id ){
        session(['set_theme'=> $id ]);
        return response()->json(['status'=>'success']);
    }


}
