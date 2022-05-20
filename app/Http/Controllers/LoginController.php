<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
  public function index() {
  	return view('login.login.login');
  }

  public function login(Request $req) {
  	$username = $req->username;
  	$password = $req->password;
  	// if ($username && $password == "admin") {
	  	return redirect()->back()->with('menu', $this->setMenu());
  	// }
		// return redirect('/errors/404');
  }

  public function setMenu() {
  	$masterfile_parentid = 1;
  	$masters_parentid = 2;
  	$cashier_parentid = 3;
  	$inventory_parentid = 4;
  	$settings_parentid = 5;

  	$parent = [
  		['parentid' => $masterfile_parentid, 'parentcode' => '001', 'parentname' => 'Masterfile'],
  		['parentid' => $masters_parentid, 'parentcode' => '002', 'parentname' => 'Masters'],
  		['parentid' => $cashier_parentid, 'parentcode' => '003', 'parentname' => 'Cashier'],
  		['parentid' => $inventory_parentid, 'parentcode' => '004', 'parentname' => 'Inventory'],
  		['parentid' => $settings_parentid, 'parentcode' => '005', 'parentname' => 'Settings'],
  	];

  	$items_childid = 1;
  	$supplier_childid = 2;
  	$category_childid = 3;
  	$pos_childid = 4;
  	$is_childid = 5;
  	$manageuser_childid = 6;
  	$managerole_childid = 7;

  	$child = [
  		// masterfile
  		['childid' => $items_childid, 'childcode' => '001-1', 'childname' => 'Items', 'parentid' => $masterfile_parentid, 'url' => '/items'],
  		['childid' => $supplier_childid, 'childcode' => '001-2', 'childname' => 'Supplier', 'parentid' => $masterfile_parentid, 'url' => '/suppliers'],
  		
  		// masters
  		['childid' => $category_childid, 'childcode' => '002-1', 'childname' => 'Category', 'parentid' => $masters_parentid],

  		// cashier
  		['childid' => $pos_childid, 'childcode' => '003-1', 'childname' => 'POS', 'parentid' => $cashier_parentid],

  		// inventory
  		['childid' => $is_childid, 'childcode' => '004-1', 'childname' => 'Inventory Setup', 'parentid' => $inventory_parentid],

  		// settings
  		['childid' => $manageuser_childid, 'childcode' => '005-1', 'childname' => 'Manage User', 'parentid' => $settings_parentid],
  		['childid' => $managerole_childid, 'childcode' => '005-2', 'childname' => 'Manage Role', 'parentid' => $settings_parentid],

  	];


  	DB::table('tblparent_menu')->truncate();
		DB::table('tblchild_menu')->truncate();

  	//parent
  	foreach ($parent as $key => $mloop) {
  		DB::table('tblparent_menu')->insert($mloop);
  	}

  	//child
  	foreach ($child as $key => $mloop) {
  		DB::table('tblchild_menu')->insert($mloop);
  	}
  }
}
