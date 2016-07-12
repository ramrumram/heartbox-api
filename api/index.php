<?php
require __DIR__ . '/vendor/jacwright/RestServer/RestServer.php';
require __DIR__ . '/vendor/php-resque/lib/Resque.php';
require __DIR__ . '/vendor/php-resque-scheduler/lib/ResqueScheduler.php';

require 'CommonController.php';
require 'VenuesController.php';
require 'MessagesController.php';
require 'UsersController.php';


$server = new \Jacwright\RestServer\RestServer('debug');
$server->addClass('TestController');
$server->addClass('VenuesController','/venues');
$server->addClass('MessagesController','/messages');
$server->addClass('UsersController','/users');

$server->handle();
