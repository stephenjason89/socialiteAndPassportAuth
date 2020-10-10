<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 48);
            $table->string('nickname', 16)->nullable();
            $table->string('username', 16)->nullable();
            $table->string('email')->unique();
            $table->unsignedTinyInteger('age')->nullable();
            $table->char('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('location', 32)->nullable();
            $table->boolean('seller')->nullable();
            $table->boolean('rider')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
//            DB::statement('ALTER TABLE users ADD FULLTEXT `search` (`first_name`, `middle_name`)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
