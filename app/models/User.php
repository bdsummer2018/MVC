<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 18.02.2019
 * Time: 20:16
 */

namespace app\models;


use core\base\Model;

class User extends Model
{
    protected static $table = "users";
    public $id;
    public $login;
    public $pass;

    public function films(){
        return $this->hasMany(Film::class,"user_id");
    }

}