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

  	$child = [
  		['childid' => $items_childid, 'childcode' => '0011', 'childname' => 'Items', 'parentid' => $masterfile_parentid],
  		['childid' => $supplier_childid, 'childcode' => '0012', 'childname' => 'Supplier', 'parentid' => $masterfile_parentid],
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
