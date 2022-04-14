<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
	public function itemList() {
  	return view('masterfile.items.items-list');
	}

  public function newItem(Request $req) {
  	$reqs = $req->all();
  	
  	return view('masterfile.items.items', ['items'=>[]]);
  }

  public function getItems(Request $req) {
  	$reqs = $req->all();
    $items = $this->fetchItems($reqs, 0);

    return $items;
  }

  private function fetchItems($req, $id = 0) {
  	$filter = [];
  	if($id != 0) {
  		$filter = ['itemid', '=', $id];
  	}

  	if (!empty($filter)) {
	  	$items = DB::table('items')->where([$filter])->get();
  	} else {
  		$items = DB::table('items')->get();
  	}

  	return $items;
  }

  public function saveItem(Request $req) {
  	$reqs = $req->all();
  	foreach ($reqs["data"] as $key => $value) {
	  	$msg = "";
	  	$status = false;
  		$itemid = 0;
  		if($value['itemid'] == 0) {
		    $itemid = DB::table('items')->insertGetId([
		    	'barcode' => $value['barcode'],
		    	'itemname' => $value['itemname'],
		    	'uomid' => 1
		    ]);
		    $msg = "Insert Success!";
		    $status = true;
  		} else {
  			DB::table('items')
  			->where('itemid', $value['itemid'])
  			->update([
		    	'barcode' => $value['barcode'],
		    	'itemname' => $value['itemname'],
		    	'uomid' => 1
		    ]);

		    $itemid = $value['itemid'];
		    $msg = "Update Success!";
		    $status = true;
  		}


	    $items = $this->fetchItems($reqs, $itemid);
	    return ['status' => $status, 'msg' => $msg, 'data' => $items];
  	}
  }
}
