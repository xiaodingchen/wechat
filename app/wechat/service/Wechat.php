<?php 
namespace App\wechat\service;

use Skinny\Component\Config as config;
use EasyWeChat\Foundation\Application;

class Wechat
{
    protected static $_wechatApp = null;
    protected static $_static = null;

    public static function instance()
    {
        if(! self::$_static instanceof self)
        {
            self::$_static = new self;
        }

        return self::$_static;
    }

    /**
     * 获取一个微信实例
     */
    public function getWechatApp()
    {
        if(! self::$_wechatApp instanceof Application)
        {
            $config = config::get('wechat.easywechat.debug');
            self::$_wechatApp = new Application($config);
        }

        return self::$_wechatApp;
    }

    /**
     * 微信普通模式
     *
     * @param $appid string 微信公众号appid
     * @return \EasyWeChat\Foundation\Application
     */
    public function normal($appId)
    {
        $app = $this->getWechatApp();
        $app['config']->set('app_id', $appId);
        $app['config']->set('secret', $this->getSecret($appId));
        $app->access_token->setCacheKey($appId);

        return $app;

    }

    /**
     * 微信授权模式
     *
     * @param $appid string 微信公众号appid
     * @return \EasyWeChat\Foundation\Application
     */

    public function authorizer(array $options = [])
    {
        $app = $this->getWechatApp();
        $app['config']->set('open_platform', $options);

        return $app;
    }

    protected function getSecret($appId)
    {
        return config::get('wechat.account.' . $appId);
    }



}
