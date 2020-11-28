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
        Schema::create('Customer_rating', function (Blueprint $table) {
            $table->foreignId("Customer_id")->comment("所屬顧客編號");
            $table->foreignId("Seller_id")->comment("所屬店家標號");
            $table->unsignedFloat("Stars")->comment("分數");
            $table->dateTime("Rating_time")->comment("評分時間");
            $table->string("Comment")->nullable()->comment("評論");
            $table->primary(["Customer_id", "Seller_id"]);
            $table->foreign("Customer_id")->references("Member_id")->on("Customer")
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
        Schema::dropIfExists('Customer_rating');
    }
}
