<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements("id")->comment("商品編號");
            $table->foreignId("seller_id")->comment("所屬店家編號");
            $table->string("name")->comment("商品名稱");
            $table->unsignedInteger("price")->comment("商品價格");
            $table->boolean("sold_out")->comment("是否已售完");
            $table->string("description")->nullable()->comment("商品描述");
            $table->dateTime("publish_time")->comment("商品建立時間");
            $table->dateTime("modified_time")->comment("商品最後更動時間");
            $table->unsignedInteger("status")->comment("商品狀態");
            $table->boolean("is_deleted")->comment("是否已被刪除");
            $table->foreignId("category_id")->nullable()->comment("所屬分類編號");
            $table->string("category_name")->nullable()->comment("所屬分類名稱");
            // $table->enum("Status", [0, 1])->comment("商品狀態");
            $table->foreign("seller_id")->references("member_id")->on("seller")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign(["category_id", "category_name"])->references(["seller_id", "name"])->on("product_category")
            ->onUpdate("cascade")->onDelete("cascade");
        });
        DB::statement('ALTER TABLE "product" ADD CONSTRAINT chk_status_of_product CHECK (status BETWEEN 0 AND 1);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
