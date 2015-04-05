<?php

class HomeController extends BaseController {
	public function Hello() {
		return View::make('hello');
	}
}