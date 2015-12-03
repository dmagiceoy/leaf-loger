<?php

require '../../vendor/autoload.php';

$logDriver = new \Leaf\Loger\Example\LogDriver();
$logDriver->setLogFile('./log.log');

$logDriver->info('test');