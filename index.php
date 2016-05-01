<?php

require __DIR__ . '/vendor/jacwright/RestServer/RestServer.php';
require 'CommonController.php';
require 'VenuesController.php';
require 'MessagesController.php';

$server = new \Jacwright\RestServer\RestServer('debug');
$server->addClass('TestController');
$server->addClass('VenuesController','/venues');
$server->addClass('MessagesController','/messages');
$server->handle();
