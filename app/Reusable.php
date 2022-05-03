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

  public function currTimeStamp() {
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
}
