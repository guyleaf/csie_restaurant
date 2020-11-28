<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsedCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Used_coupon', function (Blueprint $table) {
            $table->foreignId("Customer_id")->comment("所屬顧客編號");
            $table->foreignId("Coupon_id")->comment("所屬優惠券編號");
            $table->dateTime("Usage_time")->comment("使用時間");
            $table->primary(["Customer_id", "Coupon_id"]);
            $table->foreign("Customer_id")->references("Member_id")->on("Customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("Coupon_id")->references("Id")->on("Coupon")
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
        Schema::dropIfExists('Used_coupon');
    }
}
