<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
  public function supplierList() {
  	return view('masterfile.suppliers.suppliers-list');
	}

	public function newSupplier(Request $req, $id = 0) {
  	$reqs = $req->all();
  	$supplier = [];

  	if($id != 0) {
  		$raw_supplier = $this->fetchSuppliers($reqs, $id);

			$supplier["clientid"] = $id;
			$supplier["code"] = $raw_supplier[0]->code;
			$supplier["name"] = $raw_supplier[0]->name;
			$supplier["address"] = $raw_supplier[0]->address;
  	}
  	return view('masterfile.suppliers.suppliers', ['supplier'=>[$supplier]]);
  }

  public function getSuppliers(Request $req) {
  	$reqs = $req->all();
    $items = $this->fetchSuppliers($reqs, 0);

    return $items;
  }

  private function fetchSuppliers($req, $id = 0) {
  	$filter = [];
  	if($id != 0) {
  		$filter = ['tblclient.clientid', '=', $id];
  	}

  	if (!empty($filter)) {
	  	$supplier = DB::table('tblclient')
	  	->select('tblclient.clientid', 'tblclient.code', 'tblclient.name', 'tblclient.address',
	  	'tblclient.issupplier', 'tblclient.status')
  		->where([$filter])
	  	->get();
  	} else {
  		$supplier = DB::table('tblclient')
  		->select('tblclient.clientid', 'tblclient.code', 'tblclient.name', 'tblclient.address',
	  	'tblclient.issupplier', 'tblclient.status')
  		->get();
  	}

  	return $supplier;
  }

  public function saveSupplier(Request $req) {
  	$reqs = $req->all();
  	foreach ($reqs["data"] as $key => $value) {
	  	$msg = "";
	  	$status = false;
  		$clientid = 0;
  		if($value['clientid'] == 0) {
		    $clientid = DB::table('tblclient')->insertGetId([
		    	'code' => $value['code'],
		    	'name' => $value['name'],
		    	'address' => $value['address'],
		    ]);

		    $msg = "Insert Success!";
		    $status = true;
  		} else {
  			DB::table('tblclient')
  			->where('clientid', $value['clientid'])
        ->update([
        	'code' => $value['code'],
        	'name' => $value['name'],
        	'address' => $value['address']
        ]);

		    $clientid = $value['clientid'];
		    $msg = "Update Success!";
		    $status = true;
  		}


	    $items = $this->fetchSuppliers($reqs, $clientid);
	    return ['status' => $status, 'msg' => $msg, 'data' => $items];
  	}
  }

}
