<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
  protected $tblhead = "tbl_inv_head";
	protected $tblstock = "tbl_inv_stock";

	public $txid = 0;
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
  			// $this->yref = $value['yref'];
  		} else {
  			$this->txid = $value['txid'];
  			$this->clientid = $value['supplierid'];
  			$this->docnum = $value['docnum'];
  			// $this->yref = $value['yref'];
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
  		$filter = ['head.txid', '=', $this->txid];
  	}

  	if (!empty($filter)) {
	  	$supplier = DB::table($this->tblhead .' as head')
	  	->select('head.txid', 'head.docnum', 'head.clientid', 'supp.name as supplier')
  		->leftJoin('tblclient as supp', 'supp.clientid', '=', 'head.clientid')
  		->where([$filter])
	  	->get();
  	} else {
  		$supplier = DB::table($this->tblhead .' as head')
  		->select('head.txid', 'head.docnum', 'head.clientid', 'supp.name as supplier')
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
  			'docnum' => $this->docnum, 
  			'clientid' => $this->clientid, 
  			'dateid' => $this->dateid,
  			'yref' => $this->yref,
  			'oref' => $this->oref,
  			'rem' => $this->rem,
  		]);

	    $msg = "Insert Success!";
	    $status = true;
  	} else {
  		DB::table($this->tblhead)
			->where('txid', $this->txid)
      ->update([
      	'txid' => $this->txid, 
  			'docnum' => $this->docnum, 
  			'clientid' => $this->clientid, 
  			'dateid' => $this->dateid,
  			'yref' => $this->yref,
  			'oref' => $this->oref,
  			'rem' => $this->rem,
      ]);

      $msg = "Update Success!";
	    $status = true;
  	}

  	return ['status' => $status, 'msg' => $msg];
	}
}
