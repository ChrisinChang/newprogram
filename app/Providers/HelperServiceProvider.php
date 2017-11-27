<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    
    protected $helpser = [
        'cx',
        'fc_fn'
        ];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // echo app_path();
        ///srv/web_fc_pay/app
        foreach( $this->helpser as $help ){
            // echo $help;
            $path = app_path(). '/Helpers/' . $help . '.php';
            if( \File::isFile( $path ) ){
                // echo $help;exit()
                require_once $path;
            }
        }
        
        
        // foreach( glob(app_path().'Helpers/*.php' ) as $filename ){
        //     echo $filename;exit();
        //     require_once($filename);
        // }
        
    }
}
