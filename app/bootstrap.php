<?php

use XTheme\Server\Application;

/** show all errors! */
ini_set('display_errors', 1);
error_reporting(E_ALL);

$basepath = __DIR__ . '/..';
$app = new Application(
    array (
        'xtheme_server.basepath' => $basepath
    )
);

//$controllerResolver = new \XTheme\Viewer\ControllerResolver($app, null);
//$app['resolver'] = $controllerResolver;

return $app;
