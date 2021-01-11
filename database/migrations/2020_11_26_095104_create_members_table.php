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
        Schema::create('member', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("會員編號");
            $table->string('name')->comment("暱稱");
            $table->string('username')->unique()->comment("帳號");
            $table->longText('password')->comment("密碼");
            $table->unsignedInteger('member_status')->comment("狀態");
            $table->string('phone')->unique()->comment("電話號碼");
            $table->string('email')->unique()->comment("電子信箱");
            $table->unsignedInteger('permission')->comment("權限");
            $table->dateTime('created_at')->comment("註冊日期");
            $table->dateTime('updated_at')->comment("最後更動日期");
            $table->dateTime('email_verified_at')->nullable()->comment("電子信箱認證狀態");
            $table->boolean("is_deleted")->default(false)->comment("是否已被刪除");
            // $table->enum("Member_status", [0, 1, 2])->comment("狀態");
            // $table->enum("Permission", [0, 1, 2])->comment("權限");
        });


        DB::statement('ALTER TABLE "member" ADD CONSTRAINT chk_status_of_member CHECK (member_status BETWEEN 0 AND 2);');
        DB::statement('ALTER TABLE "member" ADD CONSTRAINT chk_permission_of_member CHECK (permission BETWEEN 0 AND 2);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
