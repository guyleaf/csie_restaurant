<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements("id")->comment("訂單編號");
            $table->foreignId("customer_id")->comment("顧客編號");
            $table->foreignId("coupon_id")->nullable()->comment("優惠券編號");
            $table->foreignid("seller_id")->comment("商店編號");
            $table->dateTime("order_time")->comment("下單時間");
            $table->dateTime("ship_time")->nullable()->comment("運送時間");
            $table->unsignedInteger("payment_method")->comment("付款方式");
            $table->unsignedInteger("status")->comment("訂單狀態");
            $table->string("address")->nullable()->comment("送餐地址");
            $table->unsignedInteger("fee")->comment("運費");
            $table->unsignedInteger("taking_method")->comment("取餐方式");
            $table->unsignedFloat("stars")->comment("分數");
            $table->dateTime("rating_time")->comment("評分時間");
            $table->string("comment")->nullable()->comment("評論");
            // $table->enum("status", [0, 1, 2, 3, 4])->comment("訂單狀態");
            // $table->enum("taking_method", [0, 1])->comment("取餐方式");
            $table->foreign("customer_id")->references("member_id")->on("customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("coupon_id")->references("id")->on("coupon")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("seller_id")->references("member_id")->on("seller")
            ->onUpdate("cascade")->onDelete("cascade");
        });

        DB::statement('ALTER TABLE "order" ADD CONSTRAINT chk_rating_time CHECK (rating_time >= order_time);');
        DB::statement('ALTER TABLE "order" ADD CONSTRAINT chk_stars CHECK (stars BETWEEN 0 AND 5);');
        DB::statement('ALTER TABLE "order" ADD CONSTRAINT chk_status_of_order CHECK (status BETWEEN 0 AND 5);');
        DB::statement('ALTER TABLE "order" ADD CONSTRAINT chk_taking_method_of_order CHECK (taking_method BETWEEN 0 AND 1);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
