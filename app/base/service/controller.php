<?php 
namespace App\base\service;

use App\base\service\view;

class controller
{
    public function __construct()
    {

    }

    public function render($tpl, array $data = [], $return = false)
    {
        $tplpath = APP_DIR . '/' . $tpl;

        return view::instance()->make($tplpath, $data, $return);
    }
}
