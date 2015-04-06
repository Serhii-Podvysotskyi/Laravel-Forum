<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUserInfoTable extends Migration {
    public function up() {
        Schema::create('user_infos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name1')->nullable();
            $table->string('name2')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->default('default.png');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::drop('user_infos');
    }
}
