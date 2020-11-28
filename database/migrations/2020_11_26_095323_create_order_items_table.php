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
        Schema::create('Order_item', function (Blueprint $table) {
            $table->foreignId("Order_id")->comment("所屬訂單編號");
            $table->foreignId("Product_id")->comment("所屬商品編號");
            $table->unsignedInteger("Quantity")->default(1)->comment("訂購數量");
            $table->string("Note")->nullable()->comment("商品備註");
            $table->primary(["Order_id", "Product_id"]);
            $table->foreign("Order_id")->references("Id")->on("Order")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("Product_id")->references("Id")->on("Product")
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
        Schema::dropIfExists('Order_item');
    }
}
