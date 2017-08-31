<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManyFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('guid')->after('id')->unique()->comment('user global unique id');
            $table->string('mobile')->after('email')->unique()->comment('user mobile，必须唯一')->nullable();
            $table->string('user_name')->after('name')->unique()->comment('user name，必须唯一')->nullable();
            $table->string('nick_name')->after('password')->unique()->comment('user nickname')->nullable();
            $table->tinyInteger('gender')->after('nick_name')->default(0)->comment('用户性别: 0,保密 1.男 2,女');
            $table->integer('birthday')->after('gender')->comment('用户生日')->nullable();
            $table->string('face')->after('birthday')->comment('用户头像')->nullable();
            $table->string('face200')->after('face')->comment('用户头像200*200')->nullable();
            $table->string('faceSrc')->after('face200')->comment('头像原图')->nullable();
            $table->string('push_token')->after('faceSrc')->comment('用户设备push_token')->nullable();
            $table->tinyInteger('user_role')->after('push_token')->unsigned()->default('1')->comment('用户状态：1.正常用户 2.禁言用户 3.虚拟用户 4.运营 5.其他');
            $table->tinyInteger('register_source')->after('user_role')->unsigned()->default('1')->comment('用户注册来源：1.邮箱 2.手机号 3.用户名 4.qq 5.微信 6.新浪微博 7.facebook 8.twitter 9.google');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('guid');
            $table->dropColumn('mobile');
            $table->dropColumn('user_name');
            $table->dropColumn('nick_name');
            $table->dropColumn('gender');
            $table->dropColumn('birthday');
            $table->dropColumn('face');
            $table->dropColumn('face200');
            $table->dropColumn('faceSrc');
            $table->dropColumn('push_token');
            $table->dropColumn('user_role');
            $table->dropColumn('register_source');
        });
    }
}
