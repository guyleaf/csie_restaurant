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
        Schema::create('specified_coupon_product', function (Blueprint $table) {
            $table->foreignId("coupon_id")->comment("所屬優惠券編號");
            $table->foreignId("product_id")->comment("商品編號");
            $table->unsignedInteger("quantity")->default(1)->comment("商品數量");
            $table->primary(["coupon_id", "product_id"]);
            $table->foreign("coupon_id")->references("id")->on("coupon")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("product")
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
        Schema::dropIfExists('specified_coupon_product');
    }
}
