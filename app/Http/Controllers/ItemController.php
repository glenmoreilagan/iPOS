<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NavController;

use App\Item;
use App\Reusable;

class ItemController extends Controller
{
	public $item_class;
  public $reuse_class;
  public $navs = [];

	public function __construct() {
		$this->item_class = new Item;
    $this->reuse_class = new Reusable;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
	}

	public function itemList() {
    // dd(session('userinfo'));
  	return view('masterfile.items.items-list', ['navs' => $this->navs]);
	}

  public function newItem(Request $req, $id = 0) {
  	$reqs = $req->all();
  	$items = [];

  	if($id != 0) {
  		$raw_items = $this->item_class->getItem($id);

      $items["itemid"] = $raw_items[0]->itemid;
      $items["barcode"] = $raw_items[0]->barcode;
      $items["itemname"] = $raw_items[0]->itemname;
      $items["uomid"] = $raw_items[0]->uomid;
      $items["uom"] = $raw_items[0]->uom;
  	} else {
      $items['barcode'] = $this->reuse_class->newBarcode();
    }
  	return view('masterfile.items.items', ['items'=>[$items], 'navs' => $this->navs]);
  }

  public function getItems(Request $req) {
  	$reqs = $req->all();
    $items = $this->item_class->getItem();
    return $items;
  }

  public function saveItem(Request $req) {
  	$reqs = $req->all();

    $items = $this->item_class->setItem($reqs);
    return ['status' => $items['status'], 'msg' => $items['msg'], 'data' => $items['data']];
  }



  public function getUom(Request $req) {
    $reqs = $req->all();
    $items = $this->fetchUom($reqs, $reqs["data"]["itemid"]);

    return $items;
  }

  private function fetchUom($req, $itemid = 0) {
    $filter = [];
    if($itemid != 0) {
      $filter = ['itemid', '=', $itemid];
    }

    if (!empty($filter)) {
      $items = DB::table('tbluom')->where([$filter])->get();
    } else {
      $items = [];
    }

    return $items;
  }
  
  public function saveUom(Request $req) {
  	$reqs = $req->all();

  	foreach ($reqs as $key => $value) {
  		$msg = "";
	  	$status = false;
  		$uomid = 0;
  		if($value['uomid'] == 0) {
		    $uomid = DB::table('tbluom')->insertGetId([
		    	'itemid' => $value['itemid'],
		    	'uom' => $value['uom'],
		    	// 'cost' => $value['cost'],
		    	'amt' => $value['amt']
		    ]);
		    $msg = "Insert Success!";
		    $status = true;
  		} else {
  			DB::table('tbluom')
  			->where([
  				['itemid', '=', $value['itemid']],
  				['uomid', '=', $value['uomid']]
  			])
  			->update([
		    	'uom' => $value['uom'],
		    	// 'cost' => $value['cost'],
		    	'amt' => $value['amt'],
		    ]);

		    $uomid = $value['uomid'];
		    $msg = "Update Success!";
		    $status = true;
	  	}

	  	$uom = $this->fetchUom($reqs, $uomid);
	    return ['status' => $status, 'msg' => $msg, 'data' => $uom];
	  }
	}
}
