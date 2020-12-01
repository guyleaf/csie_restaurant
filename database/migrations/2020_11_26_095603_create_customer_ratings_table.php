<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_rating', function (Blueprint $table) {
            $table->foreignId("customer_id")->comment("所屬顧客編號");
            $table->foreignId("seller_id")->comment("所屬店家標號");
            $table->unsignedFloat("stars")->comment("分數");
            $table->dateTime("rating_time")->comment("評分時間");
            $table->string("comment")->nullable()->comment("評論");
            $table->primary(["customer_id", "seller_id"]);
            $table->foreign("customer_id")->references("member_id")->on("customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("seller_id")->references("member_id")->on("seller")
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
        Schema::dropIfExists('customer_rating');
    }
}
