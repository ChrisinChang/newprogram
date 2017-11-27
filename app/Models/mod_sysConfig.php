<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class mod_sysConfig extends Model
{
    //
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    
    protected $table = "sysConfig";
    
    
    protected $primaryKey = 'id';
    
    
    // public $timestamps = false;
    
    public function getAllConfig(){
        // return $this->all()->orderBy('akey' , 'desc')->toArray();
        
        $arrData = [];
        
        $arrData = $this->where('id' , '>' , 0 )->orderBy('akey' , 'asc')->orderBy('skey' , 'asc')->get()->toArray();
        
        return $arrData;
        
    }
    
    public function getConfigByAkey( $_akey ){
        $arrData = [];
        
        $arrData = $this->where('akey' , '=' , $_akey )->orderBy('akey' , 'asc')->orderBy('skey' , 'asc')->get()->toArray();
        
        return $arrData;
    }
    
    public function getConfDataByAkey( $_akey ){
        $_arr = $this->getConfigByAkey( $_akey );
        $arrData = [];
        foreach( $_arr as $_val ){
            $arrData[ $_val['skey'] ] = $_val['svalue'];
        }
        
        
        return $arrData;
    }
    
    
    public function getConfigPage(){
        $arrData = [];
        
        $arrData = $this->where('id' , '>' , 0  )->orderBy('akey' , 'asc')->orderBy('skey' , 'asc')->paginate(30);
        
        return $arrData;
    }
    
    public function updateData( $aData ){
        
        $aUpdateSet = [ 'akey' , 'skey' , 'svalue' ];
        
        $aSave = cxdb_checkArray($aUpdateSet , $aData );
        
        $this->where('id' ,  $aData['id']  )
                ->update( $aSave );
        
    }
    
    public function deleteData( $_id ){
        $this->where('id' ,  $_id  )
                ->delete( );
    }
    
}
