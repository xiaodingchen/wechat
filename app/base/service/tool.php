<?php 
namespace App\base\service;

use request;

class tool
{
    // 生成一个页面token
    public static function token()
    {
        $token = random(16);
        $_SESSION[$token] = true;

        return $token;
    }

    public static function checkToken()
    {
        $token = request::input('token');

        if($token)
        {
            if($_SESSION[$token] === true)
            {
                unset($_SESSION[$token]);
            }
            else
            {
                throw new \LogicException("请不要重复提交表单");
            }
        }

        
    }
}
