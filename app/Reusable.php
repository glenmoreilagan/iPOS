<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Category;
use App\Role;
class Reusable extends Model
{
	private $category_class;
	private $role_class;

	public function __construct() {
		$this->category_class = new Category;
		$this->role_class = new Role;
	}


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

  public function setDefaultTimezone() {
  	date_default_timezone_set('Asia/Manila');
  }

  public function currDateToday() {
  	$this->setDefaultTimezone();

  	return date('Y-m-d');
  }

  public function currDateTimeToday() {
  	date_default_timezone_set('Asia/Manila');

  	return date('Y-m-d H:i');
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
  		select itemid, itemname, uomid, uom, FORMAT(sum(bal), 0) as bal, amt, category
      from (
        select stock.itemid, item.itemname, stock.uomid, uom.uom, 
        FORMAT(sum(stock.qty), 0) as bal, cat.category, ROUND(uom.amt, 2) as amt
        from tblitems as item
        inner join tbl_inv_stock as stock on stock.itemid = item.itemid
        inner join tbluom as uom on uom.uomid = stock.uomid
        left join tblcategory as cat on cat.catid = item.catid
        group by stock.itemid, item.itemname, stock.uomid, uom.uom, uom.amt, cat.category
        having sum(stock.qty) > 0
        union all
        select cart.itemid, item.itemname, cart.uomid, uom.uom, 
        FORMAT(sum(cart.qty * -1), 0) as bal, cat.category, ROUND(uom.amt, 2) as amt
        from tblitems as item
        inner join tblcart as cart on cart.itemid = item.itemid
        inner join tbluom as uom on uom.uomid = cart.uomid
        left join tblcategory as cat on cat.catid = item.catid
        group by cart.itemid, item.itemname, cart.uomid, uom.uom, uom.amt, cat.category
      ) as t
      group by itemid, itemname, uomid, uom, amt, category
  	");

  	return $items;
  }

  public function getNewOrderNum() {
  	$prefix = "OR00000";
    $userid = session('userinfo')['userid'];
  	$curr_date_today = $this->currDateToday();
  	$order_num = $this->getfieldvalue("tblhcart", "txid", "added_date='$curr_date_today'");

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

	public function checkingItemBalance($itemid, $uomid) {
    $items_bal = DB::select("select itemid, uomid, sum(inv-cart) as bal 
    from (
      select s.itemid, item.itemname, s.uomid, uom.uom, sum(s.qty) as inv, 0 as cart
      from tbl_inv_stock as s
      left join tblitems as item on item.itemid = s.itemid
      left join tbluom as uom on uom.uomid = s.uomid
      where item.itemid = ? and uom.uomid = ?
      group by s.itemid, item.itemname, s.uomid, uom.uom
      union all
      select c.itemid, item.itemname, c.uomid, uom.uom, 0 as inv, sum(c.qty) as cart
      from tblcart as c
      left join tblitems as item on item.itemid = c.itemid
      left join tbluom as uom on uom.uomid = c.uomid
      where item.itemid = ? and uom.uomid = ?
      group by c.itemid, item.itemname, c.uomid, uom.uom
    ) as t
    group by itemid, uomid", [$itemid, $uomid, $itemid, $uomid]);

		return $items_bal;
	}

	public function getCategory() {
		return $this->category_class->getCategory();
	}

	public function getRole() {
		return $this->role_class->getRole();
	}
}
