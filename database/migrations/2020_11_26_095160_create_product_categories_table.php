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
        Schema::create('Product_category', function (Blueprint $table) {
            $table->foreignId("Seller_id")->comment("所屬店家編號");
            $table->string("Name")->comment("商品類別名稱");
            $table->unsignedInteger("Display_order")->comment("顯示順序");
            $table->primary(["Seller_id", "Name"]);
            $table->foreign("Seller_id")->references("Member_id")->on("Seller")
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
        Schema::dropIfExists('Product_category');
    }
}
