<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid')->comment('全局唯一用户ID');
            $table->tinyInteger('identity_type')->default(1)->comment('用户唯一标识类型：1邮箱 2手机号 3用户名 4qq 5微信 6新浪微博 7facebook 8twitter 9google');
            $table->string('identity')->comment('用户唯一标识');
            $table->string('certificate')->comment('密码凭证(站内的保存密码，站外的不保存或者保存token)')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_auth');
    }
}
