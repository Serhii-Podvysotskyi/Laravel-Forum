<?php
class CommentLike extends Eloquent {
    protected $table = 'comment_likes';
    public function comment() {
        return $this->belongsTo('ForumComment', 'comment_id');
    }
    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
}