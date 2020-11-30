<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMallCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mall_carousel', function (Blueprint $table) {
            $table->foreignId("admin_id")->comment("由某位管理員設置");
            $table->string("image_path")->comment("輪播圖檔案路徑");
            $table->unsignedInteger("display_order")->comment("輪播順序");
            $table->primary(["admin_id", "image_path"]);
            $table->foreign("admin_id")->references("id")->on("member")
            ->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mall_carousel');
    }
}
