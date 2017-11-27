<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

use App\Models\mod_sysConfig;
// use App\Models\mod_userBase;
// use App\mod_domainBase;
// use App\mod_domainUser;



class CheckUserLevel
{
    // private $modDoainUser;
    // private $modDomain;
    private $modUser;
    private $modSys;
    
    function __construct(){
        // $this->modDoainUser =  new \App\mod_domainUser();
        // $this->modDomain = new \App\mod_domainBase();
        $this->modSys = new \App\Models\mod_sysConfig();
        // $this->modUser = new \App\Models\mod_userBase();
    }
    
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$role = "-1")
    {
        //API 
        if( $role == "API" ){
            // echo "api";
            // exit();
            return $next($request);
        }
        
        
        //userShop 用戶端 未開發
        // if( $role == "userShop"){
        //     // echo "userShop";exit();
        //     return $next($request);
        // }
        
        
        
        // if( $role == "userAdmin" ){
        //     return $this->checkUserAdmin($request , $next , $role );
        // }
        
        if( $role == "userSys" ){
            return $this->checkUserSys($request , $next , $role );
        }
        
        
        
        
        return $next($request);
    }
    
    
    private function checkUserSys($request, Closure $next ,$role = "-1"){
        
        
        // 1. 檢查用戶資訊 原本 為 admin -> AdminShop
        if (!(Auth::guard('sys')->check())  ) { 
            // echo "check bad (h)";exit();
          return redirect()->route("Sysadmin.auth.logout");
        }
        
        $AuthData=  Auth::guard('sys')->user() ;
        
        // print_cx( $AuthData );exit();
        
        //是否啟用 檢查
        if( $AuthData->is_lift == '0' ){
          return redirect()->route("Sysadmin.auth.logout");
        }
        
        
        /****
        //時間檢查
        $now = date("Y-m-d H:i:s");
        if( !( strtotime( $AuthData->DU_enable_time ) < strtotime( $now ) and 
             strtotime( $now ) < strtotime( $AuthData->DU_disable_time ) )
        ){
          echo "time bad 0";exit();
          // echo "e:" . $AuthData->DU_enable_time;
          // echo ",end:" .$AuthData->DU_disable_time;
          return redirect()->route("Sysadmin.auth.logout");
        }
        
        ****/
        
        
        // 2. 檢查用戶等級
        //檢查等級   1 一般用戶(user) , 29 : xxx , 99: root
        if( !is_numeric( $AuthData->lv_id ) ){
            // echo "num bad";exit();
            return redirect()->route("Sysadmin.auth.logout");
        }
        
        
        if( (int)$AuthData->lv_id != 99  ){
            return redirect()->route("Sysadmin.auth.logout");
        }
        
        
        
        // 3. 檢查用戶是否屬於次 url_code
        // $sUrl_code = $request->route()->getParameter('url_code');
        // // echo "<br/> url code: " . $sUrl_code;
        // //檢查 url code 是否存在
        // if( $AuthData->url_code != $sUrl_code){
        //     return redirect()->route("Sysadmin.auth.logout");
        // }
        
        
        
        
        // $sSubDomain = $request->route()->getParameter('account');
        // echo "<br/> CheckSubDomain:" . $sSubDomain;
        
        // $modDomain =  new \App\mod_domainBase();
        
        // $test = $modDomain->getAllDomains();
        
        // echo "<pre>";
        // print_r($test);
        
        // Debugbar::info($test);
        // Debugbar::error('Error!');
        // Debugbar::warning('Watch out…');



        //abort(404);
        //abort(404);
        
        // echo "<br/>";
        
        // if( $route->getParameter('account') != $user->slug ){
            
        // }
        return $next($request);
    }
    
}