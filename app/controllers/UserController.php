<?php
class UserController extends BaseController {
    public function getCreate()	{
	return View::make('user.register');
    }
    public function getLogin() {
	return View::make('user.login');
    }
    public function postCreate() {
	$validate = Validator::make(Input::all(), array(
            'username' => 'required|unique:users|min:4',
            'pass1' => 'required|min:6',
            'pass2' => 'required|same:pass1',
	));
        if ($validate->fails()) {
            return Redirect::route('getCreate')->withErrors($validate)->withInput();
	} else {
            $user = new User();
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('pass1'));
            if ($user->save()) {
                $info = new UserInfo();
                $info->user_id = $user->id;
                if ($info->save()) {
                    return Redirect::route('forum-home')
                        ->with('success', 'You registed successfully. You can now login.');
                } else {
                    $user->delete();
                }
            }
            return Redirect::route('forum-home')
                ->with('fail', 'An error occured while creating the user. Please try again.');
	}
    }
    public function postLogin() {
	$validator = Validator::make(Input::all(), array(
            'username' => 'required',
            'pass1' => 'required'
	));
	if($validator->fails()) {
            return Redirect::route('getLogin')
                ->withErrors($validator)
                ->withInput();
	} else {
            $remember = (Input::has('remember')) ? true : false;
            $auth = Auth::attempt(array(
		'username' => Input::get('username'),
		'password' => Input::get('pass1')
            ), $remember);
            if($auth) {
		return Redirect::intended('/');
            } else {
		return Redirect::route('getLogin')
                    ->with('fail', 'You entered the wrong login credentials, please try again!');
            }
	}
    }	
    public function getLogout() {
	Auth::logout();
	return Redirect::route('forum-home');
    }
    public function postFavourite($id) {
        $thread = ForumThread::find($id);
        if($thread->isFavourite()) {
            $thread->favourites()->where('user_id', Auth::user()->id)->delete();
        } else {
            UserFavourite::insert(array(
                'user_id' => Auth::user()->id,
                'thread_id' => $id));
        }
    }
    public function getAccount($id) {
        $user = User::find($id);
        return View::make('user.account')
            ->with('user', $user);
    }
    public function setName($id) {
        $validator = Validator::make(Input::all(), array(
            'Name' => 'required'
	));
        if($validator->fails()) {
            return Redirect::route('forum-user', Auth::user()->id)
                ->with('fail', 'Name wasn\'t required!');
	} else {
            $info = Auth::user()->info()->first();
            switch ($id) {
                case 1:
                    if ($info->name1 == Input::get('Name')) {
                        return Redirect::route('forum-user', Auth::user()->id);
                    }
                    $info->name1 = Input::get('Name');
                    break;
                case 2:
                    if ($info->name2 == Input::get('Name')) {
                        return Redirect::route('forum-user', Auth::user()->id);
                    }
                    $info->name2 = Input::get('Name');
                    break;
                default :
                    break;
            }
            $info->save();
            return Redirect::route('forum-user', Auth::user()->id)
                ->with('success', 'Name was changed!');
        }
    }
    public function setEmail() {
        $validator = Validator::make(Input::all(), array(
            'Email' => 'required|E-mail'
	));
        if($validator->fails()) {
            return Redirect::route('forum-user', Auth::user()->id)
                ->withErrors($validator)
                ->withInput();
	} else {
            return Redirect::route('forum-user', Auth::user()->id)
                ->with('success', 'You have specified an email!');
	}
    }
}