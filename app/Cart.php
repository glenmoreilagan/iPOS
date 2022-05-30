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
  }

  public function setCart($data) {
    $this->userid = session('userinfo')['userid'];

  	foreach ($data["data"] as $key => $value) {
  		$cart = [];

      // $defaultqty = 1;
  		$qty = isset($value["qty"]) ? $value["qty"] : 1;
      $this->line = isset($value["line"]) ? $value["line"] : 0;
      $this->txid = $data["txid"];
  		$this->itemid = $value["itemid"];
      $this->uomid = isset($value["uomid"]) ? $value["uomid"] : 0;
      $this->qty = $qty;
      $this->amt = $value["amt"];
      $this->total = $value["amt"] * $qty;
  		$this->added_date = $this->reuse_class->currDateToday();
  		$this->ordernum = $this->reuse_class->getNewOrderNum();	  		

  		if ($this->txid != 0) {
	  		// $this->qty = $value["qty"];
	  		// $this->amt = $value["amt"];
	  		// $this->total = $value["amt"] * $value["qty"];
  		} else {
	  		// $this->uomid = $value["uomid"];
	  		// $this->qty = $defaultqty;
	  		// $this->amt = $value["amt"];
	  		// $this->total = $value["amt"] * $defaultqty;
  		}

  		$save_cart = $this->saveCart();

  		// dd($save_cart);

  		if(!$save_cart) {
  			return ["status" => false, "msg" => "Saving Failed!"]; 
  		}
  	}

  	return ["status" => true, "msg" => "Saving Success!"];
  }

  public function saveCart() {
    $where_items = ["txid" => $this->txid, "itemid" => $this->itemid, "userid" => $this->userid];

  	if ($this->line != 0 && $this->txid != 0) {
      $where_items["line"] = $this->line;
      $update = DB::table($this->tblcart)

      ->where($where_items)
      ->update([
        "qty" => $this->qty,
        "amt" => $this->amt,
        "total" => $this->total,
      ]);

  		return $update;
  	} else {
      if ($this->txid != 0) {
        $insert = DB::table($this->tblcart)
        ->where($where_items)
        ->update([
          "qty" => DB::raw("qty + ".$this->qty.""),
          "amt" => DB::raw("amt + ".$this->amt.""),
          "total" => DB::raw("total + ".$this->total.""),
        ]);
      } else {
        $checking = DB::table($this->tblcart)->select(["txid"])->orderBy('txid', 'desc')->first();
        if ($this->txid == 0) {
          $this->txid = (!empty($checking)) ? $checking->txid + 1 : 1;
        }

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
      }
  		return $insert;
  	}
  }
}
