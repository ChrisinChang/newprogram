<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];




    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
     /*
    public function boot()
    {
        $this->registerPolicies();

        //
    }
    */
    
    
    public function boot()
    {
        // $this->registerPolicies();
        require_once app_path(). '/Providers/FCoreEloquentUserProvider.php';
        
        $this->registerPolicies();
         \Auth::provider('FCoreEloquentUserProvider', function($app, $config){
            return new FCoreEloquentUserProvider($this->app['hash'], $config['model']);
        });

        //
    }
    
    
    
    
}
