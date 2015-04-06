<?php
class ForumComment extends Eloquent {
    protected $table = 'forum_comments';
    public function group() {
	return $this->belongsTo('ForumGroup');
    }
    public function category() {
	return $this->belongsTo('ForumCategory');
    }
    public function thread() {
	return $this->belongsTo('ForumThread');
    }
    public function author() {
	return $this->belongsTo('User');
    }
    public function likes() {
        return $this->hasMany('CommentLike', 'comment_id');
    }
    public function isLike() {
        return ($this->likes()->where('user_id', Auth::user()->id)->count() == 0)? false : true;
    }
}