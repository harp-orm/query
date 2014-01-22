<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Openbuildings\Cherry\Test', __DIR__);

require __DIR__.'/Openbuildings/Cherry/TestCase.php';