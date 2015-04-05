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
}