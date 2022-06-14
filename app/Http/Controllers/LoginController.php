<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;

use Session;
// use Auth;
use App\User;

class LoginController extends Controller
{
  public function index() {
    if (session::has('userinfo')) {
      if (!empty(session()->get('userinfo'))) {
        $roleid = session()->get('userinfo')['roleid'];
        $redirect_url = $this->redirectUrl($roleid);

        return redirect($redirect_url);
      }
    }

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => 'https://yts.mx/api/v2/list_movies.json',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'GET',
    //   CURLOPT_HTTPHEADER => [
    //     'Content-Type: application/json'
    //   ]
    // ));
    // $response = curl_exec($curl);
    // if (curl_errno($curl)) {     
    //    $error_msg = curl_error($curl); 
    //    echo $error_msg; 
    //    return;
    // } 
    // curl_close($curl);
    // $decode_response = json_decode($response);
    // dd($decode_response);

    // dd($req->headers);

  	return view('login.login.login');
  }

  public function login(Request $req) {
  	$username = $req->username;
  	$password = $req->password;

    // dd($req->header('authorrr'));
    // return;
    $auth_key = $req->header('yut');
    if (!isset($auth_key) || $auth_key != md5("test")) {
      return ["status" => false, "msg" => "Please check credentials!", "path" => ""];
    }

    $users = DB::table("tblusers")
    ->where([ ["username", $username], ["password_hash", md5($password)] ])
    ->select(["userid", "username", "email", "roleid"])
    ->first();
    
    if (!empty($users)) {
      // setup menus
      $this->setMenu();

      Session(['userinfo' => [
          'userid' => $users->userid,
          'username' => $users->username,
          'email' => $users->email,
          'roleid' => $users->roleid,
        ]
      ]);

      $redirect_url = $this->redirectUrl($users->roleid);
      return ["status" => true, "msg" => "Login Success!", "path" => $redirect_url];
    }

	  return ["status" => false, "msg" => "Please check username and password!", "path" => ""];
  }

  public function logout(Request $req) {
    Session::flush();
    return redirect("/login");
  }

  private function setMenu() {
  	$dashboard_parentid = 1;
    $masterfile_parentid = 2;
  	$masters_parentid = 3;
  	$cashier_parentid = 4;
  	$inventory_parentid = 5;
  	$settings_parentid = 6;

  	$parent = [
  		['parentid' => $dashboard_parentid, 'parentcode' => '01', 'parentname' => 'Dashboard'],
      ['parentid' => $masterfile_parentid, 'parentcode' => '001', 'parentname' => 'Masterfile'],
  		['parentid' => $masters_parentid, 'parentcode' => '002', 'parentname' => 'Masters'],
  		['parentid' => $cashier_parentid, 'parentcode' => '003', 'parentname' => 'Cashier'],
  		['parentid' => $inventory_parentid, 'parentcode' => '004', 'parentname' => 'Inventory'],
  		['parentid' => $settings_parentid, 'parentcode' => '005', 'parentname' => 'Settings'],
  	];

  	$dashboard_childid = 1;
    $items_childid = 2;
  	$supplier_childid = 3;
  	$category_childid = 4;
  	$pos_childid = 5;
  	$is_childid = 6;
  	$manageuser_childid = 7;
  	$managerole_childid = 8;

  	$child = [
      // dashboard
      ['childid' => $dashboard_childid, 'childcode' => '01-1', 'childname' => 'Dashboard', 'parentid' => $dashboard_parentid, 
      'url' => '/dashboard'],

  		// masterfile
  		['childid' => $items_childid, 'childcode' => '001-1', 'childname' => 'Items', 'parentid' => $masterfile_parentid, 
      'url' => '/items'],
  		['childid' => $supplier_childid, 'childcode' => '001-2', 'childname' => 'Supplier', 'parentid' => $masterfile_parentid, 
      'url' => '/suppliers'],
  		
  		// masters
  		['childid' => $category_childid, 'childcode' => '002-1', 'childname' => 'Category', 'parentid' => $masters_parentid, 
      'url' => '/category'],

  		// cashier
  		['childid' => $pos_childid, 'childcode' => '003-1', 'childname' => 'POS', 'parentid' => $cashier_parentid, 
      'url' => '/POS'],

  		// inventory
  		['childid' => $is_childid, 'childcode' => '004-1', 'childname' => 'Inventory Setup', 'parentid' => $inventory_parentid, 
      'url' => '/IS'],

  		// settings
  		['childid' => $manageuser_childid, 'childcode' => '005-1', 'childname' => 'Manage User', 'parentid' => $settings_parentid, 
      'url' => '/user'],
  		['childid' => $managerole_childid, 'childcode' => '005-2', 'childname' => 'Manage Role', 'parentid' => $settings_parentid, 
      'url' => '/roles'],

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

  private function redirectUrl($roleid) {
    $redirect_url = DB::table("tblaccess as acc")
    ->where([ ["acc.roleid", $roleid] ])
    ->select(["child.url"])
    ->join("tblchild_menu as child", "child.childid", "=", "acc.childid")
    ->orderBy("child.childid", "ASC")
    ->first();

    return $redirect_url->url;
  }
}
