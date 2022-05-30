<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
	protected $tblcategory = "tblcategory";
	public $catid = 0;
	public $category = "";

  public function getCategory($data = []) {
  	if (!empty($data)) {
  		$this->catid = $data["catid"];
  	}

	 	$selectqry = ["catid", "category", "status"];
  	if ($this->catid != 0) {
		 	$category = DB::table('tblcategory')->where(["catid" => $this->catid])->select($selectqry)->get();
  	} else {
		 	$category = DB::table('tblcategory')->select($selectqry)->get();
  	}

	 	return $category;
 	}

 	public function setCategory($data) {
 		$this->catid = $data["data"][0]["catid"];
		$this->category = $data["data"][0]["category"];
 	}

 	public function saveCategory() {
 		if ($this->catid == 0) {
	 		$this->catid = DB::table($this->tblcategory)
  		->insertGetId([
  			'category' => $this->category,
  		]);

	    $msg = "Insert Success!";
	    $status = true;
 		} else {
 			DB::table($this->tblcategory)
			->where(['catid' => $this->catid])
      ->update([
  			'category' => $this->category,
      ]);

      $msg = "Update Success!";
	    $status = true;
 		}

 		return $status;
 	}
}
