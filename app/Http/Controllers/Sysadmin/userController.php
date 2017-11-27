<?php

namespace App\Http\Controllers\Sysadmin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\mod_sysConfig;
use App\Models\mod_userBase;
use Auth;



class userController extends Controller
{
    
    private $modDoainUser;
    private $modDomain;
    
    function __construct(){
        // $this->modDoainUser =  new \App\mod_domainUser();
        // $this->modDomain = new \App\mod_domainBase();
        $this->modSys = new \App\Models\mod_sysConfig();
        $this->modUser = new \App\Models\mod_userBase();
        
    }
    
    public function index(){
        $this->AuthData = Auth::guard( "sys" )->user();
        // print_cx( $this->AuthData );
       
        
        //sys_lv
        $aSysLv = $this->modSys->getConfDataByAkey("sys_lv");
        
        // print_cx($aSysLv);exit();
        
        // $dbData = $this->modUser->getPage( 30 );
        
        $TPL = array();
        // $TPL['adata'] = $dbData->toArray()['data'];
        // $TPL['dbData'] = $dbData;
        // $TPL['domainData'] = $domainData;
        $TPL['aSysLv'] = $aSysLv;
        $TPL['aType']= ['0' => '禁用' , '1'=> '啟用' ];
        $TPL['dbUserData'] = $this->modUser->getPage(3);
        $TPL['aUserData'] = $TPL['dbUserData']->toArray()['data'];
        return View::make('sys.user.list' , [ 'TPL' => $TPL] );
        
        
    }
    
    

    
    public function createUser( Request $request ){

        /*
            [user_str] => a
            [passwd] => b
            [lv_id] => c
            [is_life] => 1
            [enable_time] => 2016-01-23 11:30:00
            [disable_time] => 2016-01-23 11:30:00
            [momo] => d
        */

        // print_cx( $request->all() );exit();
        $input = $request->all() ;
        
        //檢查帳號
        $check_val = Validator::make( $input , [
            'user_str' => 'required|alpha_dash|max:32|min:4',
            'passwd' => 'required|max:32',
            'lv_id' => 'required|numeric|max:100',
            'is_life' => 'required|numeric|max:5',
            'enable_time' => 'required|date',
            'disable_time' => 'required|date',
            'memo' =>'max:255'
        ]);
        
        //檢查資料
        if ( $check_val->fails() )
        {
            $messages = $check_val->messages();
            $input['core_type'] = "bad";
            $input['core_msg'] = $messages;
            $input['core_html'] = cxcore_alert( "錯誤: 資料有誤<br/>".cxcore_msg_json2html($messages) , "danger" );
            echo json_encode($input);
            exit();
            // return redirect()->back()->withErrors( $check_val->errors() );
        }
        
        //檢查帳號是否重覆
        $iCount = $this->modUser->countByUser_str( $input['user_str'] );
        // echo  "count:" .$iCount;
        if( $iCount != 0 ){
            $input['core_type'] = "bad";
            $input['core_msg'] = "帳號重複";
            $input['core_html'] = cxcore_alert( "錯誤: 帳號重複" , "danger" );
            echo json_encode($input);
            exit();
        }
        
        $this->modUser->user_str = trim( $input['user_str'] );
        $this->modUser->passwd = $input['passwd'];
        $this->modUser->passwd_hash = Hash::make( $input['passwd'] );//md5( $input['passwd'] );
        $this->modUser->type = $type;
        $this->modUser->lv_id = $input['lv_id'];
        $this->modUser->is_life = $input['is_life'];
        $this->modUser->memo = $input['memo'];
        $this->modUser->save();
        $input['core_type'] = "ok";
        $input['core_msg'] = "create ok";
        $input['core_html'] = cxcore_alert( "新增完成", "success" );
        echo json_encode($input);
    }
    
    
    
    
    public function editUser( Request $request ){
        $input = $request->all();
        
        // print_cx( $input );exit();
        
        /**
             [id] => 5
            [user_str] => 2asdf
            [passwd] => asfd
            [lv_id] => 0
            [is_life] => 1
            [enable_time] => 2017-08-25 12:00:00
            [disable_time] => 2018-03-09 12:00:00
            [momo] => asdf
         */
        
        if( !cxcore_isInt( $input['id'] ) ){
            $input['core_type'] = "bad";
            $input['core_msg'] = $messages;
            $input['core_html'] = cxcore_alert( "錯誤: 系統資訊有誤" , "danger" );
            echo json_encode($input);
            exit();
        }
        
        $check_val = Validator::make( $input , [
            'id' => 'required|alpha_dash',
            'passwd' => 'required|max:32',
            'lv_id' => 'required|numeric|max:100',
            'is_life' => 'required|numeric|max:100',
            'enable_time' => 'date',
            'disable_time' => 'date',
            'momo' =>'max:255',
            'action' => 'required|alpha_dash'
        ]);
        
        
        //檢查資料
        if ( $check_val->fails() )
        {
            $messages = $check_val->messages();
            $input['core_type'] = "bad";
            $input['core_msg'] = $messages;
            $input['core_html'] = cxcore_alert( "錯誤: 資料有誤<br/>".cxcore_msg_json2html($messages) , "danger" );
            echo json_encode($input);
            exit();
            // return redirect()->back()->withErrors( $check_val->errors() );
        }
        
        switch ( $input['action'] ) {
            case 'edit':
                unset($input['user_str']);
                //Hash::make( $input['passwd'] );
                $input['passwd_hash'] =  Hash::make( $input['passwd'] );
                $this->modUser->updateData( $input );
                break;
                
            case 'delete':
                //刪除用戶
                $this->modUser->deleteData( $input['id'] );
                
                // //刪除用戶domains
                // $this->modDoainUser->deleteDataByUid( $input['id'] );
                
                //刪除用戶 userData (未開發) 未來關聯系統
                //cx.....
                
                
                break;
            
            default:
                echo "bad";
                exit();
                
                break;
        }
        
        // print_cx($input);
        $input['core_type'] = "ok";
        $input['core_msg'] = "ok";
        $input['core_html'] = cxcore_alert( "完成", "success" );
        echo json_encode($input);
    }
    
}