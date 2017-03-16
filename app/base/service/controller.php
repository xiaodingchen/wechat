<?php 
namespace App\base\service;

use App\base\service\view;

class controller
{
    private $_layout = 'main';
    private $_title = 'skinny';
    private $_theme = 'default';

    public function __construct()
    {

    }

    public function fetch($tpl, array $data = [])
    {
        $tplpath = APP_DIR . '/' . $tpl;

        return view::instance()->make($tplpath, $data, true);
    }

    public function render($tpl, array $data = [])
    {
        $pagedata['title'] = $this->_title;
        $pagedata['view'] = APP_DIR . '/' . $tpl;
        $pagedata['data'] = $data;
        $viewpath = THEME_DIR . '/' . $this->_theme . '/' . $this->_layout . '.html';

        return view::instance()->make($viewpath, $pagedata);
    }

    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setTheme($theme)
    {
        $this->_theme = $theme;
    }
}
