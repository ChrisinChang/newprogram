<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysCreateUserData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('userData', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('u_id')->comment("userBase->id");
            
            
            $table->string('name',64)->comment("姓名");
            $table->string('phone',64)->nullable()->comment("電話");
            $table->string('Email',128)->nullable()->comment("Email");
            
            $table->mediumText('memo')->nullable()->comment("json 備註");
            
            
            // $table->string('xxxxx',64)->nullable()->comment("xxxxx");
            $table->timestamps();
        });
        
        
        
        Schema::table('userData', function (Blueprint $table) {
           
            $table->index('u_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userData');
    }
}
