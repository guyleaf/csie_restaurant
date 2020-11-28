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
        Schema::create('Mall_carousel', function (Blueprint $table) {
            $table->foreignId("Admin_id")->comment("由某位管理員設置");
            $table->string("Image_path")->comment("輪播圖檔案路徑");
            $table->unsignedInteger("Display_order")->comment("輪播順序");
            $table->primary(["Admin_id", "Image_path"]);
            $table->foreign("Admin_id")->references("Id")->on("Member")
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
        Schema::dropIfExists('Mall_carousel');
    }
}
