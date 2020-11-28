<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerCategoryListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Seller_category_list', function (Blueprint $table) {
            $table->foreignId("Seller_id")->comment("所屬商店編號");
            $table->foreignId("Category_id")->comment("所屬商店類別");
            $table->primary(["Seller_id", "Category_id"]);
            $table->foreign("Seller_id")->references("Member_id")->on("Seller")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("Category_id")->references("Category_id")->on("Seller_category")
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
        Schema::dropIfExists('Seller_category_list');
    }
}
