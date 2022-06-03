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

      $checking_item_bal = $this->reuse_class->checkingItemBalance($this->itemid, $this->uomid);

      if ($this->qty > $checking_item_bal[0]->bal) {
        return ["status" => false, "msg" => "Out of stock!"]; 
      }
    }
  	return ["status" => true, "msg" => "Set Props Success!"];
  }

  public function saveCart() {
  	if ($this->line != 0 && $this->txid != 0) {
      $where_items = ["line" => $this->line, "txid" => $this->txid, "itemid" => $this->itemid, "userid" => $this->userid];
      $update = DB::table($this->tblcart)
      ->where($where_items)
      ->update([
        "qty" => $this->qty,
        "amt" => $this->amt,
        "total" => $this->total,
      ]);

  		return $update;
  	} else {
      $get_new_txid = DB::table($this->tblcart)->select(["txid"])->orderBy('txid', 'desc')->first();
      if ($this->txid == 0) {
        $this->txid = (!empty($get_new_txid)) ? $get_new_txid->txid + 1 : 1;
      }

      $item_exist_checking = DB::table($this->tblcart)
      ->where(["txid" => $this->txid, "itemid" => $this->itemid])
      ->select(["itemid"])
      ->first();

      if (!empty($item_exist_checking)) {
        $where_items = ["txid" => $this->txid, "itemid" => $this->itemid, "userid" => $this->userid];
        $update = DB::table($this->tblcart)
        ->where($where_items)
        ->update([
          "qty" => DB::raw("qty + ".$this->qty.""),
          "amt" => DB::raw("amt + ".$this->amt.""),
          "total" => DB::raw("total + ".$this->total.""),
        ]);
        return $update;
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
    		return $insert;
      }
  	}
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
