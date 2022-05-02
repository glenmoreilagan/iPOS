<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Inventory;
use App\Reusable;
use App\Item;

class InventoryController extends Controller
{
	public $inventory_class;
	public $reuse_class;
	public $item_class;

	public function __construct() {
    $this->inventory_class = new Inventory;
    $this->reuse_class = new Reusable;
    $this->item_class = new Item;
  }

  public function setupList() {
  	return view('inventory.inventory_setup.is-list');
	}

	public function newSetup(Request $req, $id = 0) {
		$data = [];
		if ($id != 0) {
			$is_data = $this->inventory_class->getHead($id);
			array_push($data, [
				"txid" => $is_data[0]->txid,
				"docnum" => $is_data[0]->docnum,
				"supplierid" => $is_data[0]->clientid,
				"supplier" => $is_data[0]->supplier,
				"dateid" => $is_data[0]->dateid
			]);
		} else {
			$docnum = $this->reuse_class->newInventoryDocno();
			$dateid = $this->reuse_class->currTimeStamp();

			array_push($data, ['docnum' => $docnum, 'dateid' => $dateid]);
		}
  	return view('inventory.inventory_setup.setup', ['head' => $data]);
	}

	public function getSetup(Request $req) {
  	$reqs = $req->all();
    $items = $this->inventory_class->getHead();
    return $items;
  }

	public function saveSetup(Request $req) {
  	$reqs = $req->all();
  	$setHead = $this->inventory_class->setHead($reqs);

  	return $setHead;
	}

	public function getItems(Request $req) {
  	$reqs = $req->all();
    $items = $this->item_class->getItem();
    return $items;
  }

  public function addItem(Request $req) {
  	$reqs = $req->all();

  	foreach ($reqs['data'] as $key => $value) {
	    $items = $this->item_class->getItem($value);
	    $newline = $this->reuse_class->newInventoryLine() + 1;
  		$r_items = [
  			'txid' => $reqs['txid'],
  			'line' => $newline,
  			'itemid' => $items[0]->itemid,
  		];

  		DB::table('tbl_inv_stock')->insert($r_items);
  	}

    // $stock = $this->inventory_class->getStock($reqs['txid']);
    return ['status' => true, 'msg' => 'Add Item Success!'];
  }

  public function loadStock(Request $req) {
  	$reqs = $req->all();

  	$stock = $this->inventory_class->getStock($reqs['txid']);
    return $stock;
  }
}
