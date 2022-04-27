<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
  public function setupList() {
  	return view('inventory.inventory_setup.is-list');
	}

	public function getSetup() {
  	return view('inventory.inventory_setup.setup');
	}
}
