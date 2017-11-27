<?php

namespace App\Http\Controllers\Sysadmin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;
use Validator;
use App\Models\mod_sysConfig;

// use App\mod_userBase;
// use App\mod_domainBase;
// use App\mod_domainUser;

use Illuminate\Support\Facades\Route;

use Auth;


class authController extends Controller
{
    
    private $modDoainUser;
    private $modDomain;
    
    function __construct(){
        // $this->modDoainUser =  new \App\mod_domainUser();
        // $this->modDomain = new \App\mod_domainBase();
        $this->modSys = new \App\Models\mod_sysConfig();
        // $this->modUser = new \App\mod_userBase();
    }
    
    public function index(){
        $TPL = array();
        return View::make('sys.login' , [ 'TPL' => $TPL] );
    }
    
    public function test(){
        // echo "cx:";
        // $aSys = $this->modSys->getConfigPage();
        // $aSys = $this->modSys->getConfigPage();
        
        // print_cx( $aSys );
        
        
        $TPL = array();
        // $TPL['adata'] = $aSys->toArray()['data'];
        // $TPL['aSys'] = $aSys;
        
        // return View::make('sys.z_test' , [ 'TPL' => $TPL] );
        // return View::make('sys.login' , [ 'TPL' => $TPL] );
        
        
        return View::make('sys.test' , [ 'TPL' => $TPL] );
        // return View::make('sys.login' , [ 'TPL' => $TPL] );
    
        
    }
    
    public function checkLogin(  Request $request ){
        $input = $request->all();
        
        
        
        // session(['key' => 'test2']);
        //$value = session('key');
        
        // $data = $request->session()->all();
        
        // print_cx( $data);
        
        // dd( $input );
        
        // 資料檢查
        $check_val = Validator::make( $input , [
            'user' => 'required|alpha_dash|max:32',
            'passwd' => 'required|alpha_dash|max:32'
        ]);
        
        if ( $check_val->fails() )
        {
            // The given data did not pass validation
            $messages = $check_val->messages();
            
            // $input['core_type'] = "bad";
            // $input['core_msg'] = $messages;
            // $input['core_html'] = cxcore_alert( "錯誤: 資料有誤<br/>".cxcore_msg_json2html($messages) , "danger" );
            // echo json_encode($input);

            // exit();
            return redirect()->back()->withErrors( $check_val->errors() );
        }
        
        
        if (Auth::guard('sys')->attempt( [ 
                                'user_str' => $input['user'] , 
                                'passwd_hash' => $input['passwd'] 
                                // 'sub_name' => $aDomain['sub'] ,
                                // 'base_name' => $aDomain['main']
                            ])) {
            
            
            
            return redirect()->route("Sysadmin.user.index");
            
            
            // $aAuthData = Auth::guard( "sys" )->user();
            // print_cx($aAuthData );
            // print_cx( Auth::user() );exit();
            //echo "check ok";
            
            
            // dd( Auth::user() );
            
        }else{
            // echo "check bad";
            return redirect()->back()->withErrors( '帳號或密碼有誤!' );
        }
        
        // print_cx( $request->all() );
        // exit();
        
        
    }
    
  
    
    public function logout(){
        
        Auth::logout();
        return redirect()->route("Sysadmin.auth.index");
        
    }
    
}
