<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NavController;

use App\Role;
class RoleController extends Controller
{
	public $role_class;
  public $navs = [];

	public function __construct() {
		$this->role_class = new Role;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
	}

	public function index() {
		return view("settings.roles.roles-list", ['navs' => $this->navs]);
	}

	public function newRole(Request $req, $id = 0) {

		$parent_menus = $this->role_class->parentMenu();
		$child_menus = $this->role_class->childMenu($id);
		$role_info = $this->role_class->getRole($id);

		return view("settings.roles.roles", ["parent_menus" => $parent_menus, "child_menus" => $child_menus, 'data' => $role_info, 'navs' => $this->navs]);
	}

	public function saveRole(Request $req) {
		$reqs = $req->all();
		
		$roleid = $this->role_class->setRole($reqs);
		$role_info = $this->role_class->getRole($roleid);
		
		return ["status" => true, "msg" => "Saving Success!", "data" => $role_info];
	}

	public function getRoles(Request $req) {
		$roles = $this->role_class->getRole();
		
		return $roles;
	}
}
