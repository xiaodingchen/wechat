<?php

// 定义系统目录
require (__DIR__.'/paths.php');

require (__DIR__.'/autoload.php');

require (LIB_DIR.'/Kernel.php');

Kernel::startExceptionHandling();

$config = \Skinny\Component\Config::get('app');
$timezone = $config['timezone']?:8;
date_default_timezone_set('Etc/GMT'.($timezone>=0?($timezone*-1):'+'.($timezone*-1)));


