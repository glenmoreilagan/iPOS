<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\DB;

use App\Reusable;

class DashboardController extends Controller
{
	public $reuse_class;

	public function __construct() {
    $this->reuse_class = new Reusable;
    $this->navs['parent'] = NavController::getNav()['parent'];
    $this->navs['child'] = NavController::getNav()['child'];
  }

  public function dashboard() {
  	return view('dashboard.dashboard', ['navs' => $this->navs]);
	}

	public function annualChart(Request $req) {
		$annual = DB::select("
			select year,
			sum(january) as january, 
			sum(february) as february, 
			sum(march) as march,
			sum(april) as april, 
			sum(may) as may, 
			sum(june) as june,
			sum(july) as july, 
			sum(august) as august, 
			sum(september) as september, 
			sum(october) as october, 
			sum(november) as november, 
			sum(december) as december
			from (
			select year(added_date) as year,
			MONTH(added_date) as month_num,
			if(MONTH(added_date) = 1, sum(total), 0) as january,
			if(MONTH(added_date) = 2, sum(total), 0) as february,
			if(MONTH(added_date) = 3, sum(total), 0) as march,
			if(MONTH(added_date) = 4, sum(total), 0) as april,
			if(MONTH(added_date) = 5, sum(total), 0) as may,
			if(MONTH(added_date) = 6, sum(total), 0) as june,
			if(MONTH(added_date) = 7, sum(total), 0) as july,
			if(MONTH(added_date) = 8, sum(total), 0) as august,
			if(MONTH(added_date) = 9, sum(total), 0) as september,
			if(MONTH(added_date) = 10, sum(total), 0) as october,
			if(MONTH(added_date) = 11, sum(total), 0) as november,
			if(MONTH(added_date) = 12, sum(total), 0) as december
			from tblcart
			where year(added_date) between year(DATE_SUB(now(), INTERVAL 2 YEAR)) and year(now())
			group by added_date ) as t
			group by year
			order by year, month_num
		");

		$weekly = DB::select("
			select year,
			sum(mon) as mon,
      sum(tue) as tue,
      sum(wed) as wed,
      sum(thu) as thu,
      sum(fri) as fri,
      sum(sat) as sat,
      sum(sun) as sun
			from (
			select year(added_date) as year,
			if(DAYNAME(added_date) = 'Monday', sum(total), 0) as mon,
      if(DAYNAME(added_date) = 'Tuesday', sum(total), 0) as tue,
      if(DAYNAME(added_date) = 'Wednesday', sum(total), 0) as wed,
      if(DAYNAME(added_date) = 'Thursday', sum(total), 0) as thu,
      if(DAYNAME(added_date) = 'Friday', sum(total), 0) as fri,
      if(DAYNAME(added_date) = 'Saturday', sum(total), 0) as sat,
      if(DAYNAME(added_date) = 'Sunday', sum(total), 0) as sun
			from tblcart
			where
      year(added_date) = year(now()) and
      DAY(added_date) between DAY(DATE_SUB(now(), INTERVAL 7 DAY)) and DAY(now())
			group by added_date ) as t
			group by year
			order by year
		");

		return json_encode(["annual" => $annual, "weekly" => $weekly]);
	}

	public function summarydata(Request $req) {
		$date_now = $this->reuse_class->currDateToday();
		$year_now = date('Y', strtotime($this->reuse_class->currDateToday()));

		$daily_sale = DB::table("tblcart")
		->where(["added_date" => $date_now, "ispaid" => 1])
		->select(DB::raw("FORMAT(sum(total), 0) as total_sales"))
		->first();

		$annual_sale = DB::table("tblcart")
		->whereYear("added_date", "=", $year_now)
		->select(DB::raw("FORMAT(sum(total), 0) as total_sales"))
		->first();

		$total_trans = DB::table("tblcart")->count('txid');
		$total_users = DB::table("tblusers")->count('userid');

		$data = [
			'daily_sale' => $daily_sale->total_sales != 0 ? $daily_sale->total_sales : 0,
			'annual_sale' => $annual_sale->total_sales != 0 ? $annual_sale->total_sales : 0,
			'total_trans' => $total_trans != 0 ? $total_trans : 0,
			'total_users' => $total_users != 0 ? $total_users : 0,
		];

		return json_encode(['status' => true, 'msg' => 'Fetch Success!', 'data' => $data]);
	}

	public function highLowStocks(Request $req) {
		$high_stocks =  $this->reuse_class->getItemWithBal("DESC", 10);
		$low_stocks =  $this->reuse_class->getItemWithBal("ASC", 10);

		$data = [
			'high_stocks' => $high_stocks,
			'low_stocks' => $low_stocks,
		];

		return json_encode(['status' => true, 'msg' => 'Fetch Success!', 'data' => $data]);
	}
}
