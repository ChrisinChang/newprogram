<?php namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;



class FCoreEloquentUserProvider extends EloquentUserProvider
{
    
    public function retrieveByCredentials(array $credentials)
    {
        // dd( $this->model );
        if (empty($credentials)) {
            return;
        }
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();
        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'passwd_hash')) {
                $query->where($key, $value);
            }
        }
        
        // print_cx( $query->first() );exit();
        
        return $query->first();
    }
    

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['passwd_hash'];
        // echo "p:" . $plain;
        
        
        // print_cx( $user->getAuthLevelId() );
        // exit();
        
        // echo $user->getAuthPassword();
        // dd( $user->getAuthPassword()  );
        
        // echo "cake";
        // exit();
        
        // $authPassword = $user->getAuthPassword();
        // return sha1($authPassword['salt'] . sha1($authPassword['salt'] . sha1($plain))) == $authPassword['password'];
        return $this->hasher->check($plain, $user->getAuthPassword() );
    }
    
    
    
}