<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginLogoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login_logouts', function (Blueprint $table) {
            $table->increments('id');
            //foreign key didn't work...
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_id');
            $table->string('session_id');
            $table->dateTime('login');
            $table->dateTime('logout');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_login_logouts');
    }
}
