<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->comments('用户ID');
            $table->string('guid')->comments('用户全局ID');
            $table->string('title')->comments('反馈标题');
            $table->string('contents')->comments('反馈内容');
            $table->tinyInteger('from_type')->comments('反馈来源类型: 0,网站 1,游戏 2,发行站 3')->nullable();
            $table->Integer('from_type_id')->comments('反馈来源的ID: ')->nullable();
            $table->string('from_type_name')->comments('反馈来源的名称: 0,网站 1,游戏 2,发行站 3')->nullable();
            $table->integer('status')->comments('反馈的状态: 0,【默认】,1：已查看 4:已删除')->default(0);
            $table->string('remarks')->comments('备注')->nullable();
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
        Schema::dropIfExists('feedbacks');
    }
}
