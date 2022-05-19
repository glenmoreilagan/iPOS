<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
	protected $tblroles = "tblroles";
	public $roleid = 0;
	public $role = "";

	public $acess_list;

	public function parentMenu() {
		$selectqry = [
			"p.parentid", "p.parentcode", "p.parentname"
		];
		$parent_menus = DB::table("tblparent_menu as p")
    ->select($selectqry)
		->orderBy("p.parentid", "ASC")
    ->get();

    return $parent_menus;
	}

	public function childMenu($id = 0) {
		$selectqry = [
			"c.childid", "c.parentid", "c.childcode", "c.childname"
		];
    $child_menus = DB::table("tblchild_menu as c")
    ->select($selectqry)
    ->selectRaw("'' as isallow")
		->orderBy("c.childid", "ASC")
    ->get();

    if ($id != 0) {
    	$selectqry = [
    		"r.roleid", "r.role", "parent.parentname", "child.childname", "parent.parentid", "child.childid"
    	];
    	$access_list = DB::table($this->tblroles. " as r")
    	->select($selectqry)
    	->leftJoin("tblaccess as acc", "acc.roleid", "=", "r.roleid")
    	->leftJoin("tblparent_menu as parent", "parent.parentid", "=", "acc.parentid")
    	->leftJoin("tblchild_menu as child", "child.childid", "=", "acc.childid")
    	->where([
	    		["r.roleid", "=", $id]
	    	])
    	->groupBy("r.roleid", "r.role", "parent.parentname", "child.childname", "parent.parentid", "child.childid")
    	->orderBy("child.childid", "ASC")
    	->get();

			foreach ($child_menus as $key => $child) {
				foreach ($access_list as $k => $access) {
					if ($child->childid == $access->childid) {
						$child->isallow = "checked";
					}
				}
			}
    }

    return $child_menus;
	}

	public function setRole($data) {
		$this->roleid = $data['roleinfo'][0]["roleid"];
		$this->role = $data['roleinfo'][0]["role"];
		$this->acess_list = $data['data'];

		$this->saveRole();

		return $this->roleid;
	}

	private function saveRole() {
		if ($this->roleid == 0) {
			$role_data = [
				"roleid" => $this->roleid,
				"role" => $this->role,
			];
			$this->roleid = DB::table("tblroles")->insertGetid($role_data);

			if(!$this->roleid) {
				return ["status" => false, "msg" => "Saving Failed!"];
			}
		} else {
			DB::table("tblroles")->where("roleid", $this->roleid)->update(["role" => $this->role]);
			DB::table("tblaccess")->where("roleid", $this->roleid)->delete();
		}

		foreach ($this->acess_list as $key => $value) {
			$access_data = [
				"roleid" => $this->roleid,
				"parentid" => $value["parentid"],
				"childid" => $value["childid"],
			];

			$insert_role = DB::table("tblaccess")->insert($access_data);

			if(!$insert_role) {
				return ["status" => false, "msg" => "Saving Failed!"];
			}
		}
	}

	public function getRole($roleid) {
		$rolesinfo = DB::table("tblroles")->select("roleid", "role")->where("roleid", "=", $roleid)->first();

		return $rolesinfo;
	}
}
