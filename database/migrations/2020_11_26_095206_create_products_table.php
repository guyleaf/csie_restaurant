<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Product', function (Blueprint $table) {
            $table->bigIncrements("Id")->comment("商品編號");
            $table->foreignId("Seller_id")->comment("所屬店家編號");
            $table->string("Name")->comment("商品名稱");
            $table->unsignedInteger("Price")->comment("商品價格");
            $table->boolean("Sold_out")->comment("是否已售完");
            $table->string("Description")->nullable()->comment("商品描述");
            $table->dateTime("Publish_time")->comment("商品建立時間");
            $table->dateTime("Modified_time")->comment("商品最後更動時間");
            // $table->unsignedInteger("Status")->comment("商品狀態");
            $table->boolean("Is_deleted")->comment("是否已被刪除");
            $table->foreignId("Category_id")->nullable()->comment("所屬分類編號");
            $table->string("Category_name")->nullable()->comment("所屬分類名稱");
            $table->enum("Status", [0, 1])->comment("商品狀態");
            $table->foreign("Seller_id")->references("Member_id")->on("Seller")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign(["Category_id", "Category_name"])->references(["Seller_id", "Name"])->on("Product_category")
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
        Schema::dropIfExists('Product');
    }
}
