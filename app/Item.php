<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
  protected $tblitems = "tblitems";

  public $itemid = 0;
  public $barcode = "";
  public $itemname = "";
  public $uomid = 0;
  public $uom = "";

  public function setItem($data) {
  	foreach ($data["data"] as $key => $value) {
	  	$this->itemid = $value['itemid'];
  		if($this->itemid == 0) {
  			$this->barcode = $value['barcode'];
  			$this->itemname = $value['itemname'];
  			$this->uom = $value['uom'];
  		} else {
  			$this->itemid = $value['itemid'];
  			$this->barcode = $value['barcode'];
  			$this->itemname = $value['itemname'];
  		}

  		$save_item = $this->saveItem();

  		if (!$save_item['status']) {
		    return ['status' => false, 'msg' => "Error!", 'data' => []];
  		}

	    return ['status' => $save_item['status'], 'msg' => $save_item['msg'], 'data' => $save_item['data']];
  	}
  }

  public function getItem($id = 0) {
  	$filter = [];
  	$this->itemid = $id;
  	if($this->itemid != 0) {
  		$filter = ['tblitems.itemid', '=', $this->itemid];
  	}

  	if (!empty($filter)) {
	  	$items = DB::table('tblitems')
	  	->select('tblitems.itemid', 'tblitems.itemname', 'tblitems.barcode', 'tblitems.uomid', 'tbluom.uom')
  		->leftJoin('tbluom', 'tbluom.uomid', '=', 'tblitems.uomid')
  		->where([$filter])
	  	->get();
  	} else {
  		$items = DB::table('tblitems')
  		->select('tblitems.itemid', 'tblitems.itemname', 'tblitems.barcode', 'tblitems.uomid',
  		'tbluom.uom')
  		->leftJoin('tbluom', 'tbluom.uomid', '=', 'tblitems.uomid')
  		->get();
  	}

  	return $items;
  }

  private function saveItem() {
  	$msg = "";
  	$status = false;
  	if($this->itemid == 0) {
  		$this->itemid = DB::table($this->tblitems)
  		->insertGetId(['barcode' => $this->barcode, 'itemname' => $this->itemname]);

		  $this->uomid = DB::table('tbluom')->insertGetId(['itemid' => $this->itemid, 'uom' => $this->uom]);
      DB::table($this->tblitems)->where('itemid', $this->itemid)->update(['uomid' => $this->uomid]);

	    $msg = "Insert Success!";
	    $status = true;
  	} else {
  		DB::table($this->tblitems)
			->where('itemid', $this->itemid)
      ->update(['barcode' => $this->barcode,'itemname' => $this->itemname]);

      $msg = "Update Success!";
	    $status = true;
  	}

  	$items = $this->getItem($this->itemid);
  	return ['status' => $status, 'msg' => $msg, 'data' => $items];
  }
}
