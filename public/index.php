<?php

use Phalcon\Loader;
//use Phalcon\Di\FactoryDefault;
use Phalcon\Di;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH. '/app');


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