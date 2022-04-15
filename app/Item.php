<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $table = "tblitems";

  public $itemid = "";
  public $itemname = "";
  public $barcode = "";
  public $uomid = 0;
}
