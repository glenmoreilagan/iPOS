<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reusable extends Model
{
  public function newInventoryDocno() {
  	$pref = "IS";
  	$length = "00000";
  	$txid = DB::table('tbl_inv_head')->select('txid')->orderBy('txid', 'desc')->first();

  	if (!empty($txid)) {
	  	$txid = $txid->txid + 1;
  	} else {
	  	$txid = 1;
  	}

  	$docnum = $pref.$length.$txid;
  	return $docnum;
  }

  public function currDateToday() {
  	date_default_timezone_set('Asia/Manila');

  	return date('Y-m-d');
  }

  public function newInventoryLine($txid) {
  	$line = DB::table('tbl_inv_stock')
  	->select('line')
  	->where('txid', '=', $txid)
  	->orderBy('line', 'desc')->first();

  	return empty($line) ? 1 : $line->line + 1;
  }

  public function newBarcode() {
  	$barcode = "IT00000";
  	$itemid = DB::table('tblitems')->select('itemid')->orderBy('itemid', 'desc')->first();

  	return empty($itemid) ? $barcode."1" : $barcode.($itemid->itemid + 1);
  }

  public function getItemWithBal() {
  	$items = DB::select("
  		select item.itemid, item.itemname, item.uomid, uom.uom, sum(stock.qty) as bal,
  		ROUND(uom.amt, 2) as amt, '' as category
  		from tblitems as item
  		left join tbluom as uom on uom.uomid = item.itemid
  		left join tbl_inv_stock as stock on stock.itemid = item.itemid
  		group by item.itemid, item.itemname, item.uomid, uom.uom, uom.amt
  	");


  	$category = ["coffee", "frappe", "cookies"];
  	foreach ($items as $key => $value) {
  		$rand_cat = array_rand($category);
  		$value->category = $category[$rand_cat];
  		// array_push($items, ['category' => $category[$rand_cat]]);
  	}

  	return $items;
  }

  public function getNewOrderNum() {
  	$prefix = "OR00000";
  	$curr_date_today = $this->currDateToday();
  	$order_num = $this->getfieldvalue("tblordernum", "orid", "userid=1 and added_date='$curr_date_today'");

  	if($order_num == "") {
  		$order_num = 1;
  	}

  	$new_or_num = $prefix.$order_num;
  	return $new_or_num;
  }

  public function getfieldvalue($table, $field, $condition, $params = [], $sort = '') {
		if ($sort != '') {
			$qry = 'select ' . $field . ' as value from ' . $table . ' where ' . $condition . ' order by ' . $sort . ' limit 1';
		} else {
			$qry = 'select ' . $field . ' as value from ' . $table . ' where ' . $condition . ' limit 1';
		}

		return $this->datareader($qry, $params);
	}

	public function datareader($qry, $params = []) 	{
		$data = DB::select($qry, $params);
		
		if (!empty($data)) {
			return $data[0]->value;
		} else {
			return '';
		}
	} //end
}
