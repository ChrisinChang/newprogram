<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysCreateUserBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userBase', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_str',64)->comment("帳號");
            $table->string('passwd',64)->comment("密碼");
            $table->string('passwd_hash',128)->nullable()->comment("密碼 password_hash ");
            
            $table->string('type',64)->nullable()->comment("用戶群組 sysConfig_akey->sys_group");
            
            $table->integer('lv_id')->comment("等級 sysConfig_akey->sys_lv")->default(0);
            $table->integer('is_life')->nullable()->comment("是否啟用1:yes,0:NO")->default(1);
            
            $table->timestamp('enable_time')->nullable()->comment("啟用時間");
            $table->timestamp('disable_time')->nullable()->comment("關閉時間");
            
            $table->mediumText('memo')->nullable()->comment("json 備註");
            
            
            $table->string('remember_token',100)->nullable()->comment("remember_token");
            $table->timestamps();
        });
        
        Schema::table('userBase', function (Blueprint $table) {
            //
            $table->unique('user_str');
            
            // $table->string('email',128)->comment("email");
            
            // $table->unique('email');
            
            
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userBase');
    }
}
