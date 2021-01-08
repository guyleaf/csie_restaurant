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
        Schema::create('used_coupon', function (Blueprint $table) {
            $table->foreignId("customer_id")->comment("所屬顧客編號");
            $table->foreignId("coupon_id")->comment("所屬優惠券編號");
            $table->dateTime("usage_time")->comment("使用時間");
            $table->primary(["customer_id", "coupon_id"]);
            $table->foreign("customer_id")->references("member_id")->on("customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("coupon_id")->references("id")->on("coupon")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->index("customer_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('used_coupon');
    }
}
