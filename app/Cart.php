<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Reusable;
Use Exception;

class Cart extends Model
{
  protected $tblcart = "tblcart";
  public $line = 0;
  public $txid = 0;
  public $itemid = 0;
  public $uomid = 0;
  public $qty = 0;
  public $amt = 0;
  public $total = 0;
  public $userid = 0;
  public $added_date = "";
  public $ordernum = "";

	private $reuse_class;

  public function __construct() {
    $this->reuse_class = new Reusable;
    $this->userid = session('userinfo')['userid'];
  }

  public function setCart($data, $txid) {
    $this->txid = $txid;
    if (!empty($data)) {
  		$qty = isset($data["qty"]) ? $data["qty"] : 1;
      $this->line = isset($data["line"]) ? $data["line"] : 0;
  		$this->itemid = $data["itemid"];
      $this->uomid = isset($data["uomid"]) ? $data["uomid"] : 0;
      $this->qty = $qty;
      $this->amt = $data["amt"];
      $this->total = $data["amt"] * $qty;
  		$this->added_date = $this->reuse_class->currDateToday();
  		$this->ordernum = $this->reuse_class->getNewOrderNum();	  

      // $checking_item_bal = $this->reuse_class->checkingItemBalance($this->itemid, $this->uomid);
      // $item_exist_checking = $this->itemCartChecking();

      // if (!empty($item_exist_checking)) {
      //   $new_qty = 0;
      //   if (floatval($this->qty) > floatval($item_exist_checking->qty)) {
      //     $new_qty = floatval($this->qty) - floatval($item_exist_checking->qty);
      //   }
      //   if ($new_qty > $checking_item_bal[0]->bal) {
      //     return ["status" => false, "msg" => "Out of stock!"]; 
      //   }
      //   $this->qty = floatval($new_qty) + floatval($item_exist_checking->qty);
      //   $this->total = floatval($data["amt"]) * floatval($this->qty);
      // }
    }
  	return ["status" => true, "msg" => "Set Props Success!"];
  }

  public function saveCart() {
  	if ($this->line != 0 && $this->txid != 0) {
      $checking_item_bal = $this->reuse_class->checkingItemBalance($this->itemid, $this->uomid);
      $item_exist_checking = $this->itemCartChecking();

      if (!empty($item_exist_checking)) {
        $new_qty = 0;
        if ($this->qty > $item_exist_checking->qty) {
          $new_qty = $this->qty - $item_exist_checking->qty;
          $this->qty = $new_qty + $item_exist_checking->qty;
          $this->total = $this->amt * $this->qty;
        }
        if ($new_qty > $checking_item_bal[0]->bal) {
          return ["status" => false, "msg" => "Out of stock!"]; 
        }
      }

      $where_items = ["line" => $this->line, "txid" => $this->txid, "itemid" => $this->itemid, "userid" => $this->userid];
      $update = DB::table($this->tblcart)
      ->where($where_items)
      ->update([
        "qty" => $this->qty,
        "amt" => $this->amt,
        "total" => $this->total,
      ]);

  		$status = true;
      $msg = "Saving cart Success!";

      if (!$update) {
        $status = false;
        $msg = "Saving cart Failed!";
      }

      return ["status" => $status, "msg" => $msg];
  	} else {
      $get_new_txid = DB::table($this->tblcart)->select(["txid"])->orderBy('txid', 'desc')->first();
      if ($this->txid == 0) {
        $this->txid = (!empty($get_new_txid)) ? $get_new_txid->txid + 1 : 1;
      }

      $item_exist_checking = $this->itemCartChecking();

      if (!empty($item_exist_checking)) {
        $this->qty = $item_exist_checking->qty + $this->qty;
        $this->total = $this->qty * $this->amt;

        $where_items = ["txid" => $this->txid, "itemid" => $this->itemid, "userid" => $this->userid];
        $update = DB::table($this->tblcart)
        ->where($where_items)
        ->update([
          "qty" => $this->qty,
          "amt" => $this->amt,
          "total" => $this->total,
        ]);
        $status = true;
        $msg = "Saving cart Success!";

        if (!$update) {
          $status = false;
          $msg = "Saving cart Failed!";
        }

        return ["status" => $status, "msg" => $msg];
      } else {
    		$insert = DB::table($this->tblcart)->insert([
    			"txid" => $this->txid,
          "itemid" => $this->itemid,
    			"uomid" => $this->uomid,
    			"qty" => $this->qty,
    			"amt" => $this->amt,
    			"total" => $this->total,
    			"userid" => $this->userid,
    			"added_date" => $this->added_date,
    			"ordernum" => $this->ordernum,
    		]);
        $status = true;
        $msg = "Add to cart Success!";

        if (!$insert) {
          $status = false;
          $msg = "Add to cart Failed!";
        }

    		return ["status" => $status, "msg" => $msg];
      }
  	}
  }

  public function itemCartChecking() {
    $item_exist_checking = DB::table($this->tblcart)
      ->where(["txid" => $this->txid, "itemid" => $this->itemid])
      ->select(["itemid", "qty"])
      ->first();

    return $item_exist_checking;
  }

  public function loadCart($data) {
    $where_items = ["userid" => $this->userid, "ispaid" => 0];

    $selectqry = [
      "cart.line", "cart.txid", "cart.ordernum", "cart.itemid", 
      "cart.uomid", "cart.userid", "cart.added_date", "item.itemname",
      "uom.uomid", "uom.uom",
    ];
    
    $cart = DB::table("tblcart as cart")
    ->where($where_items)
    ->select($selectqry)
    ->selectRaw("replace(FORMAT(cart.qty, ?), ',', '') as qty, 
      replace(FORMAT(uom.amt, ?), ',', '') as amt, 
      replace(FORMAT(cart.total, ?), ',', '') as total", 
      [0, 2, 2]
    )
    ->leftJoin("tblitems as item", "item.itemid", "=", "cart.itemid")
    ->leftJoin("tbluom as uom", function($join) {
      $join->on("uom.uomid", "=", "item.uomid");
      $join->on("uom.itemid", "=", "item.itemid");
    })->get();

    return $cart;
  }

  public function checkOut($data) {
    $this->txid = $data["txid"];

    $update = DB::table($this->tblcart)
    ->where(["txid" => $this->txid,  "userid" => $this->userid])
    ->update(["ispaid" => 1]);

    return $update;
  }
}
