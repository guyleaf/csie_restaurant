<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->foreignId("customer_id")->comment("所屬顧客編號");
            $table->string("address")->comment("地址");
            $table->primary(["customer_id", "address"]);
            $table->foreign("customer_id")->references("member_id")->on("customer")
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
        Schema::dropIfExists('customer_address');
    }
}
