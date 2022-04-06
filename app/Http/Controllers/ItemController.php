<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
	public function itemList() {
  	return view('masterfile.items.items-list');
	}

  public function newItem() {
  	return view('masterfile.items.items');
  }
}
