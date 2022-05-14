<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Cart;
class CartController extends Controller
{
	private $cart_class;

	public function __construct() {
		
	}

  public function setCart(Request $req) {
  	$reqs = $req->all();
  }
}
