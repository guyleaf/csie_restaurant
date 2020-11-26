<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Member', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Name');
            $table->string('Username')->unique();
            $table->enum('Member_status', [0, 1, 2]);
            $table->string('Phone')->unique();
            $table->string('Email')->unique();
            $table->enum('Permission', [0, 1, 2]);
            $table->string('Password');
            $table->dateTime('Created_at');
            $table->dateTime('Updated_at');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Member');
    }
}
