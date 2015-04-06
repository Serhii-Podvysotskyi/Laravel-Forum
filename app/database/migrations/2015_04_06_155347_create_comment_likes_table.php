<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCommentLikesTable extends Migration {
    public function up() {
        Schema::create('comment_likes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('comment_id');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::drop('comment_likes');
    }
}