<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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

  	return $reqs;
  }
}
