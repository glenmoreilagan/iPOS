<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
	public function index() {
		return view('settings.roles.roles-list');
	}

	public function newRole() {
		$selectqry = [
			'p.parentid', 'p.parentcode', 'p.parentname'
		];
		$parent_menus = DB::table('tblparent_menu' . " as p")
    ->select($selectqry)
		->orderBy('p.parentid', 'ASC')
    ->get();

    $selectqry = [
			'c.childid', 'c.parentid', 'c.childcode', 'c.childname'
		];
    $child_menus = DB::table('tblchild_menu' . " as c")
    ->select($selectqry)
		->orderBy('c.childid', 'ASC')
    ->get();

		return view('settings.roles.roles', ['parent_menus' => $parent_menus, 'child_menus' => $child_menus]);

		// select p.parentid, p.parentname
		// from tblparent_menu as p
		// inner join tbluserrole as r on r.parentid = p.parentid
		// group by r.parentid;

		// select c.parentid, c.childid, c.childname
		// from tblchild_menu as c
		// inner join tbluserrole as r on r.childid = c.childid
		// group by c.childid;
	}

	public function saveRole(Request $req) {
		$reqs = $req->all();

		foreach ($reqs['data'] as $key => $value) {
			$role_data = [
				'roleid' => 1,
				'parentid' => $value['parentid'],
				'childid' => $value['childid'],
			];

			$insert_role = DB::table('tblaccess')->insert($role_data);
		}
		return $insert_role;
	}
}
