<?php

require __DIR__ . '/vendor/jacwright/RestServer/RestServer.php';
require 'CommonController.php';

$server = new \Jacwright\RestServer\RestServer('debug');
$server->addClass('TestController');
$server->handle();
