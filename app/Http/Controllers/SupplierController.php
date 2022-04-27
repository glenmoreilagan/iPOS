<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Supplier;

class SupplierController extends Controller
{
  public $supplier_class;

  public function __construct() {
    $this->supplier_class = new Supplier;
  }

  public function supplierList() {
  	return view('masterfile.suppliers.suppliers-list');
	}

	public function newSupplier(Request $req, $id = 0) {
  	$reqs = $req->all();
  	$supplier = [];

  	if($id != 0) {
  		$raw_supplier = $this->supplier_class->getSupplier($id);

			$supplier["clientid"] = $raw_supplier[0]->clientid;
			$supplier["code"] = $raw_supplier[0]->code;
			$supplier["name"] = $raw_supplier[0]->name;
			$supplier["address"] = $raw_supplier[0]->address;
  	}
  	return view('masterfile.suppliers.suppliers', ['supplier'=>[$supplier]]);
  }

  public function getSuppliers(Request $req) {
  	$reqs = $req->all();
    $items = $this->supplier_class->getSupplier();
    return $items;
  }

  public function saveSupplier(Request $req) {
  	$reqs = $req->all();
  	$items = $this->supplier_class->setSupplier($reqs);
    return ['status' => $items['status'], 'msg' => $items['msg'], 'data' => $items['data']];
  }
}
