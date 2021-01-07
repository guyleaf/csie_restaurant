<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->bigIncrements("id")->comment("優惠券編號");
            $table->string("code")->unique()->comment("優惠券號碼");
            $table->foreignId("member_id")->comment("由哪位會員所新增");
            $table->dateTime("start_time")->comment("優惠券開放使用時間");
            $table->dateTime("end_time")->comment("優惠券結束使用時間");
            $table->unsignedInteger("type")->comment("優惠券種類");
            $table->unsignedDouble("discount")->nullable()->comment("優惠券折扣數");
            $table->unsignedDouble("limit_money")->nullable()->comment("優惠券金額下限");
            $table->boolean("is_deleted")->default(false)->comment("優惠券金額下限");
            $table->unsignedInteger("numberOfUsage")->comment("優惠券可使用次數");
            // $table->enum("type", [0, 1, 2])->comment("優惠券種類");
            $table->foreign("member_id")->references("id")->on("member")
            ->onUpdate("cascade")->onDelete("cascade");
        });

        DB::statement('ALTER TABLE "coupon" ADD CONSTRAINT chk_condition_of_coupon CHECK (discount IS NOT NULL OR limit_money IS NOT NULL);');
        DB::statement('ALTER TABLE "coupon" ADD CONSTRAINT chk_type_of_coupon CHECK (type BETWEEN 0 AND 2);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
