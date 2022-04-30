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
  	$txid = $txid->txid + 1;
  	$docno = $pref.$length.$txid;
  	return $docno;
  }
}
