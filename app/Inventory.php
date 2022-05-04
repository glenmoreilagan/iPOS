<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Reusable;
use App\Item;

class Inventory extends Model
{
  protected $tblhead = "tbl_inv_head";
	protected $tblstock = "tbl_inv_stock";
	
	private $item_class;
	private $reuse_class;

	public $txid = 0;
	public $doc = "IS";
	public $docnum = "";
	public $clientid = 0;
	public $dateid = null;
	public $yref = "";
	public $oref = "";
	public $rem = "";
	
	public $line = "";
	public $itemid = "";
	public $qty = 0;
	public $cost = 0;

	public function __construct() {
    $this->reuse_class = new Reusable;
    $this->item_class = new Item;
  }

	public function setHead($data) {
		foreach ($data["data"] as $key => $value) {
	  	$this->txid = $value['txid'];
  		if($this->txid == 0) {
  			$this->clientid = $value['supplierid'];
  			$this->docnum = $value['docnum'];
  			$this->dateid = $value['dateid'];
  		} else {
  			$this->txid = $value['txid'];
  			$this->clientid = $value['supplierid'];
  			$this->docnum = $value['docnum'];
  			$this->dateid = $value['dateid'];
  		}

  		$save_head = $this->saveHead();

  		if (!$save_head) {
		    return ['status' => false, 'msg' => "Error!", 'data' => []];
  		}

	    $head = $this->getHead($this->txid);
	    return ['status' => true, 'msg' => "Saving Success!", 'data' => $head];
  	}
	}

	public function getHead($id = 0) {
  	$filter = [];
  	$this->txid = $id;
  	if($this->txid != 0) {
  		$filter = [
  			['head.txid', '=', $this->txid]
  		];
  	}

  	$selectqry = [
  		'head.txid', 
	  	'head.docnum', 
	  	'head.clientid', 
	  	'supp.name as supplier', 
	  	'head.dateid'
	  ];

  	if (!empty($filter)) {
	  	$supplier = DB::table($this->tblhead .' as head')
	  	->select($selectqry)
  		->leftJoin('tblclient as supp', 'supp.clientid', '=', 'head.clientid')
  		->where($filter)
	  	->get();
  	} else {
  		$supplier = DB::table($this->tblhead .' as head')
  		->select($selectqry)
  		->leftJoin('tblclient as supp', 'supp.clientid', '=', 'head.clientid')
  		->get();
  	}

  	return $supplier;
  }

	private function saveHead() {
  	$msg = "";
  	$status = false;
  	if($this->txid == 0) {
  		$this->txid = DB::table($this->tblhead)
  		->insertGetId([
  			'txid' => $this->txid, 
  			'doc' => $this->doc,
  			'docnum' => $this->docnum, 
  			'clientid' => $this->clientid, 
  			'dateid' => $this->dateid,
  			'yref' => $this->yref,
  			'oref' => $this->oref,
  			'rem' => $this->rem,
  			'dateid' => $this->dateid,
  		]);

	    $msg = "Insert Success!";
	    $status = true;
  	} else {
  		DB::table($this->tblhead)
			->where('txid', $this->txid)
      ->update([
  			'clientid' => $this->clientid, 
  			'dateid' => $this->dateid,
  			'yref' => $this->yref,
  			'oref' => $this->oref,
  			'rem' => $this->rem,
  			'dateid' => $this->dateid,
      ]);

      $msg = "Update Success!";
	    $status = true;
  	}

  	return $status;
	}

	public function getStock($id = 0) {
  	$filter = [];
  	$this->txid = $id;
  	if($this->txid != 0) {
  		$filter = [
  			['stock.txid', '=', $this->txid]
  		];
  	}

  	$selectqry = [
  		'stock.txid', 
  		'stock.line', 
	  	'stock.itemid',
	  	'item.barcode',
	  	'item.itemname',
	  	'stock.uomid',
	  ];

  	if (!empty($filter)) {
	  	$supplier = DB::table($this->tblstock .' as stock')
	  	->select($selectqry)
	  	// selectRaw to set array bindings
	  	// selectRaw as added select fields from db
	  	->selectRaw('FORMAT(stock.qty, ?) as qty, FORMAT(stock.cost, ?) as cost', [3, 4])
  		->leftJoin('tblitems as item', 'item.itemid', '=', 'stock.itemid')
  		->where($filter)
	  	->get();
  	} else {
  		$supplier = DB::table($this->tblstock .' as stock')
  		->select($selectqry)
  		// selectRaw to set array bindings
	  	// selectRaw as added select fields from db
  		->selectRaw('FORMAT(stock.qty, ?) as qty, FORMAT(stock.cost, ?) as cost', [3, 4])
  		->leftJoin('tblitems as item', 'item.itemid', '=', 'stock.itemid')
  		->get();
  	}

  	return $supplier;
  }

  public function setItemstock($data) {
  	foreach ($data['data'] as $key => $value) {
	    $items = $this->item_class->getItem($value);
	    $newline = $this->reuse_class->newInventoryLine($data['txid']);

			$this->txid = $data['txid'];
			$this->line = $newline;
			$this->itemid = $items[0]->itemid;

  		$item_stock = $this->saveItemstock();

  		if(!$item_stock) {
		  	return ['status' => false, 'msg' => 'Error!'];
  		}
  	}

  	return ['status' => true, 'msg' => 'Saving Success!'];
  }

  private function saveItemstock() {
  	$insert_item = DB::table('tbl_inv_stock')->insert([
  		'txid' => $this->txid,
  		'line' => $this->line,
  		'itemid' => $this->itemid
  	]);

		if (!$insert_item) {
	    return false;
		}

		return true;
  }

  public function setStockLine($data) {
  	foreach ($data['data'] as $key => $value) {
	    $items = $this->item_class->getItem($value);
	    $newline = $this->reuse_class->newInventoryLine($data['txid']);

			$this->txid = $data['txid'];
			$this->line = $newline;
			$this->itemid = $items[0]->itemid;

  		$item_stock = $this->saveItemstock();

  		if(!$item_stock) {
		  	return ['status' => false, 'msg' => 'Error!'];
  		}
  	}

  	return ['status' => true, 'msg' => 'Saving Success!'];
  }
}
