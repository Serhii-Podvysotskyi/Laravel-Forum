<?php

class HomeController extends BaseController {
	public function Hello() {
		return Redirect::route('forum-home');
	}
}