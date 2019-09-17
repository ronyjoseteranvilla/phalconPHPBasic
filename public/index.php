<?php

use Phalcon\Loader;
//use Phalcon\Di\FactoryDefault;
use Phalcon\Di;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH. '/app');

var_dump(APP_PATH.'/controllers/');
var_dump(file_exists(APP_PATH.'/controllers/'));
var_dump(is_dir(APP_PATH.'/controllers/'));
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH.'/controllers/'
        //APP_PATH.'/models/',
    ]
);
$loader->registerNamespaces(
    [
        'Linkfire\Assignment' => APP_PATH,
    ]
);


$loader->register();


//$di = new FactoryDefault();
$di = new Di();
$di->set("router", Router::class);

$di->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace(
            'Linkfire\Assignment\Controllers'
        );

        return $dispatcher;
    }
);

// Registering a Http\Response
$di->set("response", Response::class);
// Registering a Http\Request
$di->set("request", Request::class);


$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
/*
$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    }
);
*/


try {
    // Handle the request
    $application = new Application($di);
    $response = $application->handle();
    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}