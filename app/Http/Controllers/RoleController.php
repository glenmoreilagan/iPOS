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
			'c.parentid', 'c.childcode', 'c.childname'
		];
    $child_menus = DB::table('tblchild_menu' . " as c")
    ->select($selectqry)
		->orderBy('c.childid', 'ASC')
    ->get();

		return view('settings.roles.roles', ['parent_menus' => $parent_menus, 'child_menus' => $child_menus]);
	}
}
