<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Category;

class CategoryController extends Controller
{
	private $category_class;

	public function __construct() {
		$this->category_class = new Category;
	}

 	public function index() {
 		return view('masters.category.category');
 	}

 	public function getCategory(Request $req) {
 		$reqs = $req->all();

 		$category = $this->category_class->getCategory();

 		return $category;
 	}
}
