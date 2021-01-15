<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_card', function (Blueprint $table) {
            $table->foreignId("customer_id")->comment("所屬顧客編號");
            $table->string("credit_card")->comment("信用卡號碼");
            $table->date("expire_date")->comment("到期日期");
            $table->primary(["customer_id", "credit_card", "expire_date"]);
            $table->foreign("customer_id")->references("member_id")->on("customer")
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
        Schema::dropIfExists('credit_card');
    }
}
