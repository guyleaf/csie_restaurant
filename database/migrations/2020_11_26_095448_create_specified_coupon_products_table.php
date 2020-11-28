<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecifiedCouponProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Specified_coupon_product', function (Blueprint $table) {
            $table->foreignId("Coupon_id")->comment("所屬優惠券編號");
            $table->foreignId("Product_id")->comment("商品編號");
            $table->unsignedInteger("Quantity")->default(1)->comment("商品數量");
            $table->primary(["Coupon_id", "Product_id"]);
            $table->foreign("Coupon_id")->references("Id")->on("Coupon")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("Product_id")->references("Id")->on("Product")
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
        Schema::dropIfExists('Specified_coupon_product');
    }
}
