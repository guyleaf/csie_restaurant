<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_favorite', function (Blueprint $table) {
            $table->foreignId("customer_id")->comment("所屬顧客編號");
            $table->foreignId("seller_id")->comment("所屬店家編號");
            $table->primary(["customer_id", "seller_id"]);
            $table->foreign("customer_id")->references("member_id")->on("customer")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("seller_id")->references("member_id")->on("seller")
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
        Schema::dropIfExists('customer_favorite');
    }
}
