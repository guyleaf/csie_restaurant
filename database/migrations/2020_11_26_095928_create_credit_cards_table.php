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
        Schema::create('Credit_card', function (Blueprint $table) {
            $table->foreignId("Customer_id")->comment("所屬顧客編號");
            $table->string("Credit_card")->comment("信用卡號碼");
            $table->date("Expire_date")->comment("到期日期");
            $table->primary(["Customer_id", "Credit_card", "Expire_date"]);
            $table->foreign("Customer_id")->references("Member_id")->on("Customer")
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
        Schema::dropIfExists('Credit_card');
    }
}
