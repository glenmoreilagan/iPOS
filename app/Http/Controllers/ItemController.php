<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
	public function itemList() {
  	return view('masterfile.items.items-list');
	}

  public function newItem() {
  	return view('masterfile.items.items', ['items'=>[]]);
  }

  public function getItems(Request $req) {
  	$reqs = $req->all();
    $items = DB::table('items')->get();

    return $reqs["data"][0]["barcode"];
  }

  public function saveItem(Request $req) {
  	$reqs = $req->all();

  	foreach ($reqs["data"] as $key => $value) {
	    $itemid = DB::table('items')->insertGetI([
	    	'barcode' => $value['barcode'],
	    	'itemname' => $value['itemname'],
	    	'uomid' => 1
	    ]);

	    return $itemid;
  	}
  }
}
