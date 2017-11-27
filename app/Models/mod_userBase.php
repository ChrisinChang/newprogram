<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Request;


class mod_userBase extends Model
{
    //
    
    protected $table = "userBase";
    
    // public $timestamps = false;

    
    public function getPage($_page_number = 30 , $oInput = "" ){
        $arrData = [];
        
        
        $arrData = $this->where('id' , '>' , 0  )->
                            orderBy('created_at' , 'asc')->
                            paginate($_page_number , ['*'] , 'userPage' );
                            
        if( $oInput == "" ){
            $oInput = Request::except('userPage');
        }
        $arrData->appends( $oInput );
         
         
         
        return $arrData;
    }
    
    public function getByid( $uid ){
        $arrData = [];
        
        
        $arrData = $this->where('id' , '=' , $uid  )->first();
        if( $arrData == null ){
            return false;
        }                 
        return $arrData->toArray();                  
    }
    

    
    public function countByUser_str( $_user_str ){
        $_user_str = trim($_user_str);
        $iCount = $this->where('user_str' , $_user_str  )->count();
        
        
        return $iCount;
    }
    

    // public function 

    public function updateData( $aData ){
        
        $aUpdateSet = [ 
                        'passwd' , 
                        'passwd_hash',
                        'type' , //廢除只做副本 移至domainUser
                        'lv_id' , //廢除只做副本 移至domainUser
                        'is_lift' , //廢除只做副本 移至domainUser
                        'enable_time' , //廢除只做副本 移至domainUser
                        'disable_time' , //廢除只做副本 移至domainUser
                        'memo' 
                        ];
        
        $aSave = cxdb_checkArray($aUpdateSet , $aData );
        // dd($aSave);
        $this->where('id' ,  $aData['id']  )
                ->update( $aSave );
        
    }
    
    public function deleteData( $_id ){
        $this->where('id' ,  $_id  )
                ->delete( );
    }
    
    
    
    
}
