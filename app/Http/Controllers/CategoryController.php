<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NavController;

use App\Category;

class CategoryController extends Controller
{
	private $category_class;
  public $navs = [];

	public function __construct() {
		$this->category_class = new Category;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
	}

 	public function index() {
 		return view('masters.category.category', ['navs' => $this->navs]);
 	}

 	public function getCategory(Request $req) {
 		$reqs = $req->all();

 		$category = $this->category_class->getCategory($reqs['data']);

 		return $category;
 	}

 	public function setCategory(Request $req) {
 		$reqs = $req->all();

 		$this->category_class->setCategory($reqs);
 		$save_status = $this->category_class->saveCategory();

 		if (!$save_status) {
	 		return ["status" => false, "msg" => "Saving Failed!"];
 		}

 		return ["status" => true, "msg" => "Saving Success!"];
 	}
}
