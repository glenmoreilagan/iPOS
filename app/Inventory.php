<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
  protected $tblhead = "tbl_inv_head";
	protected $tblstock = "tbl_inv_stock";

	public $txid = 0;
	public $doc = "IS";
	public $docnum = "";
	public $clientid = 0;
	public $dateid = null;
	public $yref = "";
	public $oref = "";
	public $rem = "";

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

  		if (!$save_head['status']) {
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

  	return ['status' => $status, 'msg' => $msg];
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
	  	'stock.qty',
	  	'stock.cost',
	  ];

  	if (!empty($filter)) {
	  	$supplier = DB::table($this->tblstock .' as stock')
	  	->select($selectqry)
  		->leftJoin('tblitems as item', 'item.itemid', '=', 'stock.itemid')
  		->where($filter)
	  	->get();
  	} else {
  		$supplier = DB::table($this->tblstock .' as stock')
  		->select($selectqry)
  		->leftJoin('tblitems as item', 'item.itemid', '=', 'stock.itemid')
  		->get();
  	}

  	return $supplier;
  }
}
