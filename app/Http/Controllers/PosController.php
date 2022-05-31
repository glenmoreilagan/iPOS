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

    $save_cart = $this->cart_class->setCart($reqs);
    return ["status" => $save_cart["status"], "msg" => $save_cart["msg"]];
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
  	$selectqry = [
  		"cart.line", 
      "cart.txid", 
	  	"cart.ordernum", 
	  	"cart.itemid", 
	  	"cart.uomid", 
	  	"cart.userid", 
	  	"cart.added_date",
	  	"item.itemname",
	  	"uom.uom"
	  ];
		
		$cart = DB::table("tblcart as cart")
  	->select($selectqry)
  	->selectRaw("replace(FORMAT(cart.qty, ?), ',', '') as qty, 
  		replace(FORMAT(uom.amt, ?), ',', '') as amt, 
  		replace(FORMAT(cart.total, ?), ',', '') as total", 
  		[0, 2, 2]
  	)
  	->leftJoin("tblitems as item", "item.itemid", "=", "cart.itemid")
  	->leftJoin("tbluom as uom", function($join) {
  		$join->on("uom.uomid", "=", "item.uomid");
  		$join->on("uom.itemid", "=", "item.itemid");
  	})
  	->get();

  	return ["status" => true, "msg" => "Load Cart Success!", "data" => $cart];
  }
}
