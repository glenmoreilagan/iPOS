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
	public $uomid = 0;
	public $qty = 0;
	public $cost = 0;
  public $isposted = 0;

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

  		if (!$save_head["status"]) {
		    return ['status' => false, 'msg' => $save_head["msg"], 'data' => []];
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
	  	'head.dateid',
      'head.isposted'
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

    // if ($this->isPosted($this->txid)) {
    //   return ["status" => false, "msg" => "Already Posted!"];
    // }

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
			->where([['txid', '=', $this->txid]])
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

  	return ["status" => $status, "msg" => $msg];
	}

	public function getStock($txid = 0, $line = 0) {
  	$filter = [];
  	$this->txid = $txid;
  	$this->line = $line;

  	if($this->txid != 0) {
  		// $filter = [
  		// 	['stock.txid', '=', $this->txid]
  		// ];
  		array_push($filter, ['stock.txid', '=', $this->txid]);
  	}

  	if ($this->line != 0) {
  		array_push($filter, ['stock.line', '=', $this->line]);
  	}

  	$selectqry = [
  		"stock.txid", 
  		"stock.line", 
	  	"stock.itemid",
	  	"item.barcode",
	  	"item.itemname",
	  	"stock.uomid",
	  ];

  	if (!empty($filter)) {
	  	$stock = DB::table($this->tblstock .' as stock')
	  	->select($selectqry)
	  	// selectRaw to set array bindings
	  	// selectRaw as added select fields from db
	  	->selectRaw("FORMAT(stock.qty, ?) as qty, 
	  		FORMAT(stock.cost, ?) as cost,
	  		IFNULL(uom.uom, '') as uom", 
	  		[3, 4]
	  	)
  		->leftJoin("tblitems as item", "item.itemid", "=", "stock.itemid")
  		->leftJoin("tbluom as uom", "uom.uomid", "=", "stock.uomid")
  		->where($filter)
	  	->get();
  	} else {
  		$stock = DB::table($this->tblstock ." as stock")
  		->select($selectqry)
  		// selectRaw to set array bindings
	  	// selectRaw as added select fields from db
  		->selectRaw("FORMAT(stock.qty, ?) as qty, 
  			FORMAT(stock.cost, ?) as cost", 
  			[3, 4]
  		)
  		->leftJoin("tblitems as item", "item.itemid", "=", "stock.itemid")
  		->get();
  	}

  	return $stock;
  }

  public function setItemstock($data, $action) {
  	foreach ($data['data'] as $key => $value) {

  		switch ($action) {
  			case 'additem':
		    	$items = $this->item_class->getItem($value);
			    $itemid = !empty($items[0]->itemid) ? $items[0]->itemid : 0;
			    $uomid = !empty($items[0]->uomid) ? $items[0]->uomid : 0;
					$this->txid = $data['txid'];
					$this->itemid = $itemid;
					$this->uomid = $uomid;
				break;
  			case 'saveitem':
		    	$qty = isset($value['qty']) ? $value['qty'] : 0;
			    $cost = isset($value['cost']) ? $value['cost'] : 0;
			    $txid = $value['txid'];
					$this->line = $value['line'];
					$this->txid = $txid;
					$this->qty = $qty;
					$this->cost = $cost;
				break;
				default:
					return ['status' => false, 'msg' => 'No action!', 'data' => []];
				break;
  		}

  		$item_stock = $this->saveItemstockLine();

  		if(!$item_stock) {
		  	return ['status' => false, 'msg' => 'Error!', 'data' => []];
  		}
  	}

  	$stock = $this->getStock($this->txid, $this->line);
  	return ['status' => true, 'msg' => 'Saving Success!', 'data' => $stock];
  }

  private function saveItemstockLine() {
  	$status = false;
  	$msg = "";

  	if($this->line == 0) {
  		$newline = $this->reuse_class->newInventoryLine($this->txid);
	  	DB::table($this->tblstock)->insert([
	  		'txid' => $this->txid,
	  		'line' => $newline,
	  		'itemid' => $this->itemid,
	  		'uomid' => $this->uomid
	  	]);
	  	$msg = "Insert Success!";
	  	$status = true;
  	} else {
  		$qty = $this->qty;
  		$cost = $this->cost;

  		DB::table($this->tblstock)
			->where([
				['txid', '=', $this->txid], 
				['line', '=', $this->line]
			])
      ->update([
  			'qty' => $qty,
  			'cost' => $cost
      ]);
      $msg = "Update Success!";
      $status = true;
  	}
		return $status;
  }

  public function setTXID($data) {
    $this->txid = $data["txid"];
    // $this->isposted = $data["isposted"];
  }

  public function post() {
    if ($this->txid != 0) {
      $post = DB::table($this->tblhead)->where(["txid" => $this->txid])->update(["isposted" => 1]);

      return $post;
    }
  }  

  public function isPosted($txid) {
    $check_isposted =  DB::table($this->tblhead)->where(["txid" => $txid])->value("isposted");

    if ($check_isposted != 0) {
      return true;
    } else {
      return false;
    }
  }
}
