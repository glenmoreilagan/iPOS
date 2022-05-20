<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

use App\Reusable;
class User extends Authenticatable
{
  protected $tblusers = "tblusers";
  public $userid = 0; 
  public $name = ""; 
  public $username = ""; 
  public $email = "";
  public $password = ""; 
  public $password_hash = ""; 
  public $userrole = ""; 
  public $status = 0; 
  public $date_created = null; 
  public $roleid = 0; 

  private $reusable_class;

  public function __construct() {
    $this->reusable_class = new Reusable;
  }

  public function setUser($data) {
    foreach ($data['data'] as $key => $value) {
      $this->userid = $value['userid'];
      if ($this->userid == 0) {
        $this->username = $value['username'];
        $this->name = $value['name'];
        $this->email = $value['email'];
        $this->password = $value['password'];
        $this->password_hash = md5($value['password']);
        $this->date_created = $this->reusable_class->currDateTimeToday();
        $this->roleid = $value['roleid'];
      } else {

      }
    }

    $save_user = $this->saveUser();

    if (!$save_user['status']) {
      return ['status' => false, 'msg' => "Error!", 'data' => []];
    }

    return ['status' => $save_user['status'], 'msg' => $save_user['msg'], 'data' => $save_user['data']];
  }

  private function saveUser() {
    $status = false;
    $msg = "";

    if($this->userid == 0) {
      $this->userid = DB::table($this->tblusers)
      ->insertGetId([
        'name' => $this->name, 
        'username' => $this->username, 
        'email' => $this->email,
        'password' => $this->password,
        'password_hash' => $this->password_hash,
        'date_created' => $this->date_created,
        'roleid' => $this->roleid,
      ]);

      $status = true;
      $msg = "Saving Success!";
    } else {

    }

    return ['status' => $status, 'msg' => $msg, 'data' => []];
  }

  public function getUser($id = 0) {
    $filter = [];
    $this->userid = $id;
    if($this->userid != 0) {
      $filter = ['user.userid', '=', $this->userid];
    }

    $selectqry = ['user.userid', 'user.username', 'user.email', 'user.password', 'user.status', 'user.name',
      "user.roleid", "role.role"
    ];

    if (!empty($filter)) {
      $users = DB::table($this->tblusers . " as user")
      ->select($selectqry)
      ->leftJoin("tblroles as role", "role.roleid", "=", "user.roleid")
      ->where([$filter])
      ->get();
    } else {
      $users = DB::table($this->tblusers . " as user")
      ->select($selectqry)
      ->leftJoin("tblroles as role", "role.roleid", "=", "user.roleid")
      ->get();
    }

    return $users;
  }
}
