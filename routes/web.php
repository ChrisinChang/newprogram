<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
 
 
//最高管理者 後臺 登入
Route::get('sysadmin/test' ,'Sysadmin\authController@test')->name( 'Sysadmin.auth.test' );
Route::get('sysadmin/auth' ,'Sysadmin\authController@index')->name( 'Sysadmin.auth.index' );
Route::get('sysadmin/auth/logout' ,'Sysadmin\authController@logout')->name( 'Sysadmin.auth.logout' );
Route::post('sysadmin/auth/check' ,'Sysadmin\authController@checkLogin')->name( 'Sysadmin.auth.check' );

//最高管理者 後臺
// Route::group(  [  'domain' => 'api.' . $cxBaseUrl  ,'middleware' => 'CheckSubDomain:API'   ] , function(){
Route::group(  [  'middleware' => 'CheckUserLevel:userSys'   ] , function(){
  
    Route::get('sysadmin/user' ,'Sysadmin\userController@index')->name( 'Sysadmin.user.index' );
    
    Route::post('sysadmin/user/edit' ,'Sysadmin\userController@editUser')->name( 'Sysadmin.user.editUser' );
    Route::post('sysadmin/user/create' ,'Sysadmin\userController@createUser')->name( 'Sysadmin.user.createUser' );
    
    
    
    
});


