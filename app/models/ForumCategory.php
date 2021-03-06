<?php
class ForumCategory extends Eloquent {
    protected $table = 'forum_categories';
    public function group() {
	$this->belongsTo('ForumGroup');
    }
    public function threads() {
    	return $this->hasMany('ForumThread', 'category_id');
    }
    public function comments() {
	return $this->hasMany('ForumComment', 'category_id');
    }
    public function size() {
        return $this->threads()->count();
    }
    public function hasFavourites() {
        foreach ($this->threads()->get() as $thread) {
            if ($thread->isFavourite()) {
                return true;
            }
        }
        return false;
    }
}