<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected static $currentUser = null;

    public static function authByToken($token){
        $user = self::where('token', $token)->first();

        if($user)
            static::$currentUser = $user;
    }

    public static function login($login, $password){
        $user = self::where('login', $login)->where('password', md5($password))->first();

        if($user){
            $token = uniqid(rand(10, 100000), true);
            $user->setToken($token);
            return $token;
        }

        return null;
    }

    public function setToken($token){
        $this->token = $token;
        $this->save();
    }

    public static function hasUser(){
        return !is_null(static::$currentUser);
    }

    public static function getCurrent(){
        return static::$currentUser;
    }
}
