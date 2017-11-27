<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// use App\Scopes\UserAuthScope;

class auth_userBase extends Authenticatable
{
    protected $table='userBase';
    use Notifiable;
    
    
    
    protected static function boot( )
    {
        parent::boot();
        
        // $sDomain = Route::getCurrentRoute()->getAction();//['domain'];
        // dd( $sDomain );
        // $aDomain = cxcore_domain2array( $sDomain ) ;
        // $request = app('App\Http\Requests\ProfileSaveRequest');
        // $request = new ContactUsRequest;
        // dd( Request::all() );
        
        // $sDomain =$request->root();
        
        // dd( $aDomain );
        /*
        'sub_name' => $aDomain['sub'] 'base_name' => $aDomain['main']
        */
        
        // static::addGlobalScope(new UserAuthScope);
        static::addGlobalScope('userBaseData', function(Builder $builder) {
            $builder->select( ['*'] );
            
            /*********** OLD PROJECT
            $sDomain = url('/');
            $aDomain = cxcore_domain2array( $sDomain ) ;
            
            
            $builder->select( 
                        ['userBase.*' ,'DB.*', 
                         'DU.*' , 
                         'DU.enable_time as DU_enable_time',
                         'DU.disable_time as DU_disable_time',
                         'DU.lv_id_d as DU_lv_id_d',
                         'DU.is_lift_d as DU_is_lift_d',
                         'DU.type_d as DU_type_d',
                         'userBase.id as id'
                         ] 
                        )
                        ->leftjoin( "domainUser as DU" , "DU.u_id" , "userBase.id" )
                        ->leftjoin( "domainBase as DB" , "DU.d_id" , "DB.id" );
                        // ->leftjoin( "domainBase as DB" , function( $leftJoin ){
                        //     $leftJoin->on( "DU.d_id" , "=" , "DB.id"  );
                        //     $leftJoin->on( "DU.sub_name" , "=" , "DB.id"  );
                        //     $leftJoin->on( "DU.d_id" , "=" , "DB.id"  )
                        // } )
                        
                        // ->where( "DB.sub_name" , $aDomain['sub'] )
                        // ->where( "DB.base_name" , $aDomain['main'] );
            *****************/
            /*
            ->leftJoin('company_saved_cv', function($leftJoin)
        {
            $leftJoin->on('company_saved_cv.worker_id', '=', 'workers.id')

                ->on('company_saved_cv.company_id', '=', Session::get('company_id') );


        }
            */
            
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     /********* old project 
    protected $fillable = [
        'is_lift', 'user_str', 'passwd_hash',
        'DU_lv_id_d','DU_is_lift_d','DU_type_d',
        'DU_enable_time','DU_disable_time',
        'sub_name','base_name'
    ];
    ***********************/
    protected $fillable = [
        'is_lift', 'user_str', 'passwd_hash','lv_id','enable_time','disable_time','momo'
        ];
        
    
    
 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwd_hash', 'remember_token',
    ];
    
    public function getAuthPassword()
    {
        // dd( $this );
        return $this->passwd_hash;
    }
    
    public function getAuthLevelId()
    {
        // dd( $this );
        return $this->lv_id;
    }

    public function getRememberTokenName()
    {
        return 'userBase.remember_token';
    }
    
    
    
    
}
