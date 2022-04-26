<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
  public function inventorySetupList() {
  	return view('inventory.inventory_setup.is-list');
	}
}
