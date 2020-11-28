<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Order', function (Blueprint $table) {
            $table->bigIncrements("Id")->comment("訂單編號");
            $table->foreignId("Customer_id")->comment("顧客編號");
            $table->foreignId("Coupon_id")->comment("優惠券編號");
            $table->foreignid("Seller_id")->comment("商店編號");
            $table->dateTime("Order_time")->comment("下單時間");
            $table->dateTime("Ship_date")->nullable()->comment("運送時間");
            $table->unsignedInteger("Payment_method")->comment("付款方式");
            // $table->unsignedInteger("Status")->comment("訂單狀態");
            $table->string("Address")->nullable()->comment("送餐地址");
            $table->unsignedInteger("Fee")->comment("運費");
            // $table->unsignedInteger("Taking_method")->comment("取餐方式");
            $table->enum("Status", [0, 1, 2, 3, 4])->comment("訂單狀態");
            $table->enum("Taking_method", [0, 1])->comment("取餐方式");
            $table->foreign("Customer_id")->references("Member_id")->on("Customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("Coupon_id")->references("Id")->on("Coupon")
            ->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('Order');
    }
}
