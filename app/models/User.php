<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface, RemindableInterface {
    use UserTrait, RemindableTrait;
    protected $table = 'users';
    protected $hidden = array('password', 'remember_token');
    public function getRememberToken() {
    	return $this->remember_token;
    }
    public function setRememberToken($remember_token) {
    	$this->remember_token = $remember_token;
    }
    public function getRememberTokenName() {
    	return 'remember_token';
    }
    public function isAdmin() {
    	return($this->isAdmin ==1);
    }
    public function info() {
        return $this->hasOne('UserInfo', 'user_id');
    }
    public function threads() {
        return $this->hasMany('ForumThread', 'author_id');
    }
    public function comments() {
        return $this->hasMany('ForumComment', 'author_id');
    }
    public function favourites() {
        return $this->hasMany('UserFavourite', 'user_id');
    }
    public function getFavoriteThreads() {
        $stack = array();
        foreach ($this->favourites as $favourite) {
            array_push($stack, $favourite->thread_id);
        }
        $threads = array();
        foreach (array_unique($stack) as $id) {
            array_push($threads, ForumThread::find($id));
        }
        return $threads;
    }
    public function getThreads() {
        $stack = array();
        foreach ($this->comments as $comment) {
            array_push($stack, $comment->thread_id);
        }
        $threads = array();
        foreach (array_unique($stack) as $id) {
            array_push($threads, ForumThread::find($id));
        }
        return $threads;
    }
}