<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
	private $user_class;

	public function __construct() {
		$this->user_class = new User;
	}

  public function index() {
  	return view('settings.user.user-list');
  }

  public function setUser(Request $req) {
  	$reqs = $req->all();

  	$data = $this->user_class->setUser($reqs);

  	return ['status' => true, 'msg' => 'Saving Success!', 'data' => $data];
  }

  public function getUser(Request $req) {
  	$reqs = $req->all();

  	$userid = isset($req['data']['userid']) ? $req['data']['userid'] : 0;

  	$data = $this->user_class->getUser($userid);

  	return $data;
  }
}
