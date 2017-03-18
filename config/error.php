<?php 
return [
    'handler' => \App\base\service\webExceptionHandler::class,
    'errorpage' => STATIC_DIR . '/pages/503.html',
];
