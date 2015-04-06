<?php
class UserInfo extends Eloquent {
    protected $table = 'user_infos';
    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
}