<?php

require __DIR__.'/../bootstrap/start.php';

require 'web.php';
$web = new \Web();

$web->run();
