<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->foreignId("seller_id")->comment("所屬店家編號");
            $table->string("name")->comment("商品類別名稱");
            $table->unsignedInteger("display_order")->comment("顯示順序");
            $table->primary(["seller_id", "name"]);
            $table->foreign("seller_id")->references("member_id")->on("seller")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_category');
    }
}
