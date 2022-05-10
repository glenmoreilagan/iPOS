<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Inventory;
use App\Reusable;
use App\Item;

class InventoryController extends Controller
{
	private $inventory_class;
	private $reuse_class;
	private $item_class;

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
			if(!empty($is_data)) {
				array_push($data, [
					"txid" => $is_data[0]->txid,
					"docnum" => $is_data[0]->docnum,
					"supplierid" => $is_data[0]->clientid,
					"supplier" => $is_data[0]->supplier,
					"dateid" => $is_data[0]->dateid
				]);
			}
		} else {
			$docnum = $this->reuse_class->newInventoryDocno();
			$dateid = $this->reuse_class->currDateToday();

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
  	$stock = $this->inventory_class->setItemstock($reqs, 'additem');

    return ['status' => true, 'msg' => 'Add Item Success!', 'data' => $stock];
  }

  public function loadStock(Request $req) {
  	$reqs = $req->all();
  	$stock = $this->inventory_class->getStock($reqs['txid']);

    return $stock;
  }

  public function saveStock(Request $req) {
  	$reqs = $req->all();
  	$stock = $this->inventory_class->setItemstock($reqs, 'saveitem');

  	return ['status' => true, 'msg' => 'Saving Success!', 'data' => $stock];
  }
}
