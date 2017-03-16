<?php 
namespace App\base\service;

class template
{
    protected $css = [];
    protected $js = [];

    public function getCSS()
    {
        return $this->css;
    }

    public function getJS()
    {
        return $this->js;
    }

    public function setCSS($css = null)
    {
        if(is_array($css) && $css)
        {
            $this->css = array_merge($this->css, $css);
        }

        if(is_string($css) && $css) {$this->css[] = $css;}
    }

    public function setJS($css = null)
    {
        if(is_array($css) && $css)
        {
            $this->js = array_merge($this->js, $css);
        }

        if(is_string($css) && $css) {$this->js[] = $css;}
    }

}
