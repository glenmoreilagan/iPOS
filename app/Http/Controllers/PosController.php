<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NavController;


use App\Reusable;
use App\Cart;

class PosController extends Controller
{
	private $reuse_class;
	private $cart_class;
  public $navs = [];

	public function __construct() {
    $this->reuse_class = new Reusable;
    $this->cart_class = new Cart;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
  }

  public function index() {
  	$items = $this->reuse_class->getItemWithBal();
  	$category = $this->reuse_class->getCategory();
  	return view("cashier.pos.pos", ["items" => $items, 'category' => $category, 'navs' => $this->navs]);
  }

  public function saveCart(Request $req) {
  	$reqs = $req->all();

    foreach ($reqs["data"] as $key => $value) {
      $set_cart = $this->cart_class->setCart($value, $reqs['txid']);
      if(!$set_cart["status"]) {
       return ["status" => false, "msg" => $set_cart["msg"]]; 
      }
      $save_cart = $this->cart_class->saveCart();
      if(!$save_cart) {
       return ["status" => false, "msg" => "Saving Failed!"]; 
      }
    }
    return ["status" => true, "msg" => "Saving Success!"];
  }

  public function deleteCart(Request $req) {
  	$reqs = $req->all();

  	$delete_cart = DB::table("tblcart")->where("line", $reqs['line'])->delete();

  	if (!$delete_cart) {
  		return ["status" => false, "msg" => "Delete Failed!"];
  	}
  	return ["status" => true, "msg" => "Delete Success!"];
  }

  public function loadCart(Request $req) {
    $reqs = $req->all();
  	$cart = $this->cart_class->loadCart($reqs);

  	return ["status" => true, "msg" => "Load Cart Success!", "data" => $cart];
  }

  public function checkOut(Request $req) {
    $reqs = $req->all();

    $set_cart = $this->cart_class->setCart([], $reqs['txid']);
    $check_out = $this->cart_class->checkOut($reqs);

    if (!$check_out) {
      return ["status" => false, "msg" => "Checout Failed!"];
    }
    return ["status" => true, "msg" => "Checout Success!"];
  }
}
