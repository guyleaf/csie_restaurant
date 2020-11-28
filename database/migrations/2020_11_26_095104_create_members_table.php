<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->bigIncrements('Id')->comment("會員編號");
            $table->string('Name')->comment("暱稱");
            $table->string('Username')->unique()->comment("帳號");
            // $table->unsignedInteger('Member_status')->comment("狀態");
            $table->string('Phone')->unique()->comment("電話號碼");
            $table->string('Email')->unique()->comment("電子信箱");
            // $table->unsignedInteger('Permission')->comment("權限");
            $table->string('Password')->comment("密碼");
            $table->dateTime('Created_at')->comment("註冊日期");
            $table->dateTime('Updated_at')->comment("最後更動日期");
            $table->dateTime('Email_verified_at')->nullable()->comment("電子信箱認證狀態");
            $table->enum("Member_status", [0, 1, 2])->comment("狀態");
            $table->enum("Permission", [0, 1, 2])->comment("權限");
        });

        // DB::statement('ALTER TABLE Member ADD CONSTRAINT chk_status_of_member CHECK (Member_status BETWEEN 0 AND 2);');
        // DB::statement('ALTER TABLE Member ADD CONSTRAINT chk_permission_of_member CHECK (Permission BETWEEN 0 AND 2);');
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
