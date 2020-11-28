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
        Schema::create('Coupon', function (Blueprint $table) {
            $table->bigIncrements("Id")->comment("優惠券編號");
            $table->string("Code")->unique()->comment("優惠券號碼");
            $table->foreignId("Member_id")->comment("由哪位會員所新增");
            $table->dateTime("Start_time")->comment("優惠券開放使用時間");
            $table->dateTime("End_time")->comment("優惠券結束使用時間");
            // $table->integer("Type")->comment("優惠券種類");
            $table->unsignedDouble("Discount")->nullable()->comment("優惠券折扣％數");
            $table->unsignedDouble("Limit_money")->nullable()->comment("優惠券金額下限");
            $table->enum("Type", [0, 1, 2])->comment("優惠券種類");
            $table->foreign("Member_id")->references("Id")->on("Member");
        });

        // DB::statement('ALTER TABLE Coupon ADD CONSTRAINT chk_type_of_coupon CHECK (Discount IS NOT NULL OR Limit_money IS NOT NULL);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Coupon');
    }
}
