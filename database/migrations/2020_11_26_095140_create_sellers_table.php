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
        Schema::create('Seller', function (Blueprint $table) {
            $table->foreignId("Member_id")->comment("商店編號");
            $table->string("Desctiption")->comment("商店描述")->nullable();
            $table->unsignedBigInteger("Counter_number")->unique()->comment("櫃位號碼");
            $table->string("Header_image")->nullable()->comment("商店圖片路徑");
            $table->primary("Member_id");
            $table->foreign("Member_id")->references("Id")->on("Member")
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
        Schema::dropIfExists('Seller');
    }
}
