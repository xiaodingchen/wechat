<?php 
namespace App\base\service;

use request;
use App\base\service\session;

class tool
{
    // 生成一个页面token
    public static function token()
    {
        $token = random(16);
        
        (new session())->set('token', $token);
        return $token;
    }

    public static function checkToken()
    {
        $token = request::input('token');
        
        if($token)
        {
            $session = new session();
            if($session->get('token', '') == $token)
            {
                $session->remove('token');
            }
            else
            {
                throw new \LogicException("请不要重复提交表单");
            }
        }

        
    }
}
