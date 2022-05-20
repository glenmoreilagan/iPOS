<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Reusable;
class UserController extends Controller
{
	private $user_class;
	private $reuse_class;

	public function __construct() {
		$this->user_class = new User;
		$this->reuse_class = new Reusable;
	}

  public function index() {
  	return view('settings.user.user-list', ['nav'=>'123']);
  }

  public function setUser(Request $req) {
  	$reqs = $req->all();

  	$data = $this->user_class->setUser($reqs);

  	return ['status' => true, 'msg' => 'Saving Success!', 'data' => $data];
  }

  public function getUser(Request $req) {
  	$reqs = $req->all();

  	$userid = isset($reqs['data']['userid']) ? $reqs['data']['userid'] : 0;

  	$data = $this->user_class->getUser($userid);

  	return $data;
  }

  public function getRole(Request $req) {
  	return $this->reuse_class->getRole();
  }
}
