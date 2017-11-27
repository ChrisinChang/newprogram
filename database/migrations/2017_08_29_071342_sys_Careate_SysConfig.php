<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysCareateSysConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sysConfig', function (Blueprint $table) {
            $table->increments('id');
            $table->string('skey',128)->nullable()->comment("設定檔key");
            $table->string('svalue' , 256 )->nullable()->comment("key之內容");
            $table->string('akey',128)->nullable()->comment("key群組");
            $table->timestamps();
            
            $table->engine = 'InnoDB';
            // $table->unique('email');
            // $table->index('skey');
            // $table->index('reset_password_code');
            
        });
        
         Schema::table('sysConfig', function (Blueprint $table) {
            //
            $table->index('skey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sysConfig');
    }
}
