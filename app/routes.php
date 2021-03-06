<?php
Route::get('/', array(
    'uses'  =>	'ForumController@index',
    'as'    =>	'forum-home'));
Route::get('/category/{id}', array(
    'uses'  =>	'ForumController@category',
    'as'    =>	'forum-category'));
Route::get('/thread/{id}', array(
    'uses'  =>  'ForumController@thread',
    'as'    =>  'forum-thread'));
Route::get('/user/{id}/profile', array(
    'uses'  =>  'UserController@getAccount',
    'as'    =>  'forum-user'));
Route::group(array('before' => 'admin'), function() {
    Route::get('/group/{id}/delete', array(
	'uses'	=>  'ForumController@deleteGroup',
	'as'	=>  'forum-delete-group'));
    Route::get('/category/{id}/delete', array(
	'uses'	=>  'ForumController@deleteCategory',
	'as'	=>  'forum-delete-category'));
    Route::get('/thread/{id}/delete', array(
	'uses'	=>  'ForumController@deleteThread',
	'as'	=>  'forum-delete-thread'));
    Route::get('/comment/{id}/delete', array(
	'uses'	=>  'ForumController@deleteComment',
	'as'	=>  'forum-delete-comment'));
    Route::get('/user/{user}/delete/name/{id}', array(
        'uses'  =>  'UserController@deleteName',
        'as'    =>  'user-delete-name'));
    Route::get('/user/{id}/delete/email', array(
        'uses'  =>  'UserController@deletEmail',
        'as'    =>  'user-delete-email'));
    Route::group(array('before' => 'csrf'), function() {
	Route::post('/category/{id}/new', array(
            'uses'  =>	'ForumController@storeCategory',
            'as'    =>	'forum-store-category'));
	Route::post('/group', array(
            'uses'  =>	'ForumController@storeGroup',
            'as'    =>	'forum-store-group'));
    });
});
Route::group(array('before' => 'auth'), function() {
    Route::get('/user/logout', array(
	'uses'	=>  'UserController@getLogout',
	'as'	=>  'getLogout'));
    Route::get('/user/{id}/delete/avatar', array(
        'uses'  =>  'UserController@deleteAvatar',
        'as'    =>  'user-delete-avatar'));
    Route::post('/thread/{id}/favourite', array(
        'uses'  =>  'UserController@postFavourite',
        'as'    =>  'forum-thread-favourite'));
    Route::post('/comment/{id}/like', array(
        'uses'  =>  'ForumController@postLike',
        'as'    =>  'forum-comment-like'));
    Route::post('/user/avatar/upload', array(
            'uses'  =>  'UserController@avatarUpload',
            'as'    =>  'user-avatar-upload'));
    Route::group(array('before' => 'csrf'), function() {
	Route::post('/thread/{id}/new', array(
            'uses'  =>	'ForumController@storeThread',
            'as'    =>	'forum-store-thread'));
	Route::post('/comment/{id}/new', array(
            'uses'  =>	'ForumController@storeComment',
            'as'    =>  'forum-store-comment'));
        Route::post('/user/setname/{id}', array(
            'uses'  =>  'UserController@setName',
            'as'    =>  'user-set-name'));
        Route::post('/user/setemail', array(
            'uses'  =>  'UserController@setEmail',
            'as'    =>  'user-set-email'));
    });
});
Route::group(array('before' => 'guest'), function() {
    Route::get('/user/create', array(
	'uses'	=>  'UserController@getCreate',
	'as'	=>  'getCreate'));
    Route::get('/user/login', array(
	'uses'	=>  'UserController@getLogin',
	'as'	=>  'getLogin'));
    Route::group(array('before' => 'csrf'), function() {
        Route::post('/user/create', array(
            'uses'  =>	'UserController@postCreate',
            'as'    =>	'postCreate'));
	Route::post('/user/login', array(
            'uses'  =>	'UserController@postLogin',
            'as'    =>	'postLogin'));
    });
});