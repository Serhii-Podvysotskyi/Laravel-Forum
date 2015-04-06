<?php
class UserFavourite extends Eloquent {
    protected $table = 'user_favourites';
    public function thread() {
        return $this->belongsTo('ForumThread', 'thread_id');
    }
    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
}