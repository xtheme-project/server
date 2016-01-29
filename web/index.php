<?php

use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../vendor/autoload.php';
\AutoTune\Tuner::init($loader);

$app = require_once __DIR__ . '/../app/bootstrap.php';

$request = Request::createFromGlobals();
$app->run($request);
