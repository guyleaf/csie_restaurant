<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Product_image', function (Blueprint $table) {
            $table->string("Image_path")->comment("圖片路徑");
            $table->foreignId("Id")->comment("所屬商品編號");
            $table->primary(["Image_path", "Id"]);
            $table->foreign("Id")->references("Id")->on("Product")
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
        Schema::dropIfExists('Product_image');
    }
}
