<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


use App\Reusable;
use App\Cart;

class PosController extends Controller
{
	private $reuse_class;
	private $cart_class;

	public function __construct() {
    $this->reuse_class = new Reusable;
    $this->cart_class = new Cart;
  }

  public function index() {
  	$items = $this->reuse_class->getItemWithBal();
  	return view('cashier.pos.pos', ['items' => $items]);
  }

  public function addCart(Request $req) {
  	$reqs = $req->all();

  	foreach ($reqs['data'] as $key => $value) {
  		$cart = [];
  		$default_qty = 1;

  		$cart['itemid'] = $value['itemid'];
  		$cart['uomid'] = $value['uomid'];
  		$cart['qty'] = $default_qty;
  		$cart['amt'] = $value['amt'];
  		$cart['total'] = $value['amt'] * $default_qty;
  		$cart['userid'] = 1;
  		$cart['added_date'] = $this->reuse_class->currDateToday();
  		$cart['ordernum'] = $this->reuse_class->getNewOrderNum();

  		$insert = DB::table("tblcart")->insert($cart);

  		if(!$insert) {
  			return ['status' => false, 'msg' => 'Add to Cart Failed!'];
  		}
  	}

  	return ['status' => true, 'msg' => 'Add to Cart Success!'];
  }
}
