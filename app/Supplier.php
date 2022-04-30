<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
	protected $tblclient = "tblclient";

  public $clientid = 0;
	public $code = "";
	public $name = "";
	public $address = "";

	public function setSupplier($data) {
  	foreach ($data["data"] as $key => $value) {
	  	$this->clientid = $value['clientid'];
  		if($this->clientid == 0) {
  			$this->code = $value['code'];
  			$this->name = $value['name'];
  			$this->address = $value['address'];
  		} else {
  			$this->clientid = $value['clientid'];
  			$this->code = $value['code'];
  			$this->name = $value['name'];
  			$this->address = $value['address'];
  		}

  		$save_supplier = $this->saveSupplier();
  		if (!$save_supplier['status']) {
		    return ['status' => false, 'msg' => "Error!", 'data' => []];
  		}
  	}

    $suppliers = $this->getSupplier($this->clientid);
    return ['status' => true, 'msg' => "Saving Success!", 'data' => $suppliers];
  }

	public function getSupplier($id = 0) {
  	$filter = [];
  	$this->clientid = $id;
  	if($this->clientid != 0) {
  		$filter = ['tblclient.clientid', '=', $this->clientid];
  	}

  	if (!empty($filter)) {
	  	$supplier = DB::table($this->tblclient)
	  	->select('tblclient.clientid', 'tblclient.code', 'tblclient.name', 'tblclient.address',
	  	'tblclient.issupplier', 'tblclient.status')
  		->where([$filter])
	  	->get();
  	} else {
  		$supplier = DB::table($this->tblclient)
  		->select('tblclient.clientid', 'tblclient.code', 'tblclient.name', 'tblclient.address',
	  	'tblclient.issupplier', 'tblclient.status')
  		->get();
  	}

  	return $supplier;
  }

  private function saveSupplier() {
  	$msg = "";
  	$status = false;
  	if($this->clientid == 0) {
  		$this->clientid = DB::table($this->tblclient)
  		->insertGetId(['code' => $this->code, 'name' => $this->name, 'address' => $this->address]);

	    $msg = "Insert Success!";
	    $status = true;
  	} else {
  		DB::table($this->tblclient)
			->where('clientid', $this->clientid)
      ->update(['code' => $this->code,'name' => $this->name, 'address' => $this->address]);

      $msg = "Update Success!";
	    $status = true;
  	}

  	return ['status' => $status, 'msg' => $msg];
  }
}
