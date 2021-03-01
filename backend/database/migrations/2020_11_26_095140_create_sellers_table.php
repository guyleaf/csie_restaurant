<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->foreignId("member_id")->comment("商店編號");
            $table->string("description")->comment("商店描述")->nullable();
            $table->unsignedBigInteger("counter_number")->unique()->comment("櫃位號碼");
            $table->string("header_image")->nullable()->comment("商店圖片路徑");
            $table->primary("member_id");
            $table->foreign("member_id")->references("id")->on("member")
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
        Schema::dropIfExists('seller');
    }
}
