<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Session;

class NavController extends Controller
{
	public static function getNav() {
		$userid = session('userinfo')['userid'];

		$parent = DB::select("
			select u.userid, u.username, u.roleid, r.role, p.parentid, p.parentname
			from tblusers as u
			inner join tblroles as r on r.roleid = u.roleid
			inner join tblaccess as ac on ac.roleid = u.roleid
			inner join tblparent_menu as p on p.parentid = ac.parentid
			where u.userid = '".$userid."'
			group by u.userid, u.userid, u.username, u.roleid, r.role, p.parentname, p.parentid
			order by p.parentid
		");

		$child = DB::select("
			select u.userid, u.username, u.roleid, r.role, c.parentid, c.childname, c.url
			from tblusers as u
			inner join tblroles as r on r.roleid = u.roleid
			inner join tblaccess as ac on ac.roleid = u.roleid
			inner join tblchild_menu as c on c.childid = ac.childid
			where u.userid = '".$userid."'
			group by u.userid, u.userid, u.username, u.roleid, r.role, c.parentid, c.childname, c.url
			order by c.childid
		");
		// dd(session('userinfo'));
		return ['parent' => $parent, 'child' => $child];
	}
}
