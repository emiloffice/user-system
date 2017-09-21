<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');//关联用户ID
            $table->integer('game_id');//关联游戏ID
            $table->string('referral_code');//随机生成的推荐码
            $table->string('from_referral_code')->nullable();
            $table->string('from_referral_id')->nullable();
            $table->integer('points')->nullable();//积分
            $table->integer('points_level')->nullable();//积分
            $table->smallInteger('fb_status')->nullable()->default(0);
            $table->smallInteger('twitter_status')->nullable()->default(0);
            $table->smallInteger('discord_status')->nullable()->default(0);
            $table->smallInteger('group_status')->nullable()->default(0);
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
        Schema::dropIfExists('points');
    }
}
