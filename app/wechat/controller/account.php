<?php 
namespace App\wechat\controller;

use App\base\service\controller;

class account extends controller
{
    public function index()
    {
        $this->setTitle('编辑公众号');
        return $this->render('wechat/view/account/edit.html', []);
    }

    public function post()
    {
        
    }
}
