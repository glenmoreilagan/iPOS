<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Inventory;
use App\Reusable;

class InventoryController extends Controller
{
	public $inventory_class;
	public $reuse_class;

	public function __construct() {
    $this->inventory_class = new Inventory;
    $this->reuse_class = new Reusable;
  }

  public function setupList() {
  	return view('inventory.inventory_setup.is-list');
	}

	public function newSetup(Request $req, $id = 0) {
		if ($id != 0) {
			# code...
		} else {
			$data = [];
			$docno = $this->reuse_class->newInventoryDocno();
			$data = [
				['docno' => $docno]
			];
	  	return view('inventory.inventory_setup.setup', ['head' => $data]);
		}

	}

	public function saveSetup(Request $req) {
  	$reqs = $req->all();
  	$setHead = $this->inventory_class->setHead($reqs);

  	return $setHead;
	}
}
