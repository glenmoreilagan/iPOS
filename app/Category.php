<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
  public function getCategory($id = 0) {
	 	$selectqry = ["catid", "category", "status"];

	 	$category = DB::table('tblcategory')->select($selectqry)->get();
	 	return $category;
 }
}
