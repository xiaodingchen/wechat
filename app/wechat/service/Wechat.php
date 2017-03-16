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
     * 通过微信公众号信息取得一个Application实例
     *
     * @param array $account  关联数组：type和appid两个是必须的，type是接入模式，appid是接入公众号的app_id
     *
     * @return \EasyWeChat\Foundation\Application
     */
    public function wechatApp($account)
    {
        if(! isset($account['type']) || ! isset($account['appid']))
        {
            throw new \LogicException('缺少公众号关键信息，appid或接入模式');
        }

        if($account['type'] == 1)
        {
            $secret = isset($account['secret']) ? $account['secret'] : null;
            $encodingaeskey = isset($account['encodingaeskey']) ? $account['encodingaeskey'] : null;
            
            return $this->normal($account['appid'], $secret, $encodingaeskey);
        }

        // todo:微信开放授权模式，待完善
        if($account == 3)
        {
            return $this->authorizer();
        }

        throw new \LogicException('缺少公众号关键信息：接入信息错误');
        
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
