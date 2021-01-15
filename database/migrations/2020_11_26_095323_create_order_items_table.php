<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item', function (Blueprint $table) {
            $table->foreignId("order_id")->comment("所屬訂單編號");
            $table->foreignId("product_id")->comment("所屬商品編號");
            $table->unsignedInteger("quantity")->default(1)->comment("訂購數量");
            $table->unsignedInteger("price")->comment("商品單價");
            $table->string("note")->nullable()->comment("商品備註");
            $table->primary(["order_id", "product_id"]);
            $table->foreign("order_id")->references("id")->on("order")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("product")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->index("order_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item');
    }
}
