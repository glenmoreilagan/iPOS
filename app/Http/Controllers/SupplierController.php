<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NavController;

use App\Supplier;

class SupplierController extends Controller
{
  public $supplier_class;
  public $navs = [];

  public function __construct() {
    $this->supplier_class = new Supplier;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
  }

  public function supplierList() {
    // setcookie("GLEN-KEY", md5(123), time() + 2 * 24 * 60 * 60);
  	return view('masterfile.suppliers.suppliers-list', ['navs' => $this->navs]);
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
  	return view('masterfile.suppliers.suppliers', ['supplier'=>[$supplier], 'navs' => $this->navs]);
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
