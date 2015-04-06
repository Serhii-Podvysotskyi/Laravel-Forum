<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavouritesTable extends Migration {

    public function up()
    {
        Schema::create('user_favourites', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('thread_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user_favourites');
    }

}
