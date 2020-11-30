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
        Schema::create('seller_category_list', function (Blueprint $table) {
            $table->foreignId("seller_id")->comment("所屬商店編號");
            $table->foreignId("category_id")->comment("所屬商店類別");
            $table->primary(["seller_id", "category_id"]);
            $table->foreign("seller_id")->references("member_id")->on("seller")
            ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("category_id")->references("category_id")->on("seller_category")
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
        Schema::dropIfExists('seller_category_list');
    }
}
