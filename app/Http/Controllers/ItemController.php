<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Item;

class ItemController extends Controller
{
	public $item_class;

	public function __construct() {
		$this->item_class = new Item;
	}

	public function itemList() {
  	return view('masterfile.items.items-list');
	}

  public function newItem(Request $req, $id = 0) {
  	$reqs = $req->all();
  	$items = [];

  	if($id != 0) {
  		$raw_items = $this->fetchItems($reqs, $id);

			$items["itemid"] = $id;
			$items["barcode"] = $raw_items[0]->barcode;
			$items["itemname"] = $raw_items[0]->itemname;
			$items["uomid"] = $raw_items[0]->uomid;
			$items["uom"] = $raw_items[0]->uom;
  	}
  	return view('masterfile.items.items', ['items'=>[$items]]);
  }

  public function getItems(Request $req) {
  	$reqs = $req->all();
    $items = $this->fetchItems($reqs, 0);

    return $items;
  }

  private function fetchItems($req, $id = 0) {
  	$filter = [];
  	if($id != 0) {
  		$filter = ['tblitems.itemid', '=', $id];
  	}

  	if (!empty($filter)) {
	  	$items = DB::table('tblitems')
	  	->select('tblitems.itemid', 'tblitems.itemname', 'tblitems.barcode', 'tblitems.uomid', 'tbluom.uom')
  		->leftJoin('tbluom', 'tbluom.uomid', '=', 'tblitems.uomid')
  		->where([$filter])
	  	->get();
  	} else {
  		$items = DB::table('tblitems')
  		->select('tblitems.itemid', 'tblitems.itemname', 'tblitems.barcode', 'tblitems.uomid',
  		'tbluom.uom')
  		->leftJoin('tbluom', 'tbluom.uomid', '=', 'tblitems.uomid')
  		->get();
  	}

  	return $items;
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

  public function saveItem(Request $req) {
  	$reqs = $req->all();
  	foreach ($reqs["data"] as $key => $value) {
	  	$msg = "";
	  	$status = false;
  		$itemid = 0;
  		if($value['itemid'] == 0) {
		    $itemid = DB::table('tblitems')->insertGetId([
		    	'barcode' => $value['barcode'],
		    	'itemname' => $value['itemname']
		    ]);

        $uomid = DB::table('tbluom')->insertGetId(['itemid' => $itemid, 'uom' => $value['uom']]);
        DB::table('tblitems')->where('itemid', $itemid)->update(['uomid' => $uomid]);

		    $msg = "Insert Success!";
		    $status = true;
  		} else {
  			DB::table('tblitems')
  			->where('itemid', $value['itemid'])
        ->update(['barcode' => $value['barcode'],'itemname' => $value['itemname']]);

		    $itemid = $value['itemid'];
		    $msg = "Update Success!";
		    $status = true;
  		}


	    $items = $this->fetchItems($reqs, $itemid);
	    return ['status' => $status, 'msg' => $msg, 'data' => $items];
  	}
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
		    	'cost' => $value['cost'],
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
		    	'cost' => $value['cost'],
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
