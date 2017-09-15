<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUpdateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_update_project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_gid')->comments('游戏id');
            $table->string('game_name')->comments('游戏名称');
            $table->string('game_version')->comments('游戏版本');
            $table->dateTime('game_update_at')->comments('游戏此次版本更新时间');
            $table->string('update_content')->comments('更新计划内容')->nullable();
            $table->string('remark')->comments('更新计划内容')->nullable();
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
        Schema::dropIfExists('game_update_project');
    }
}
