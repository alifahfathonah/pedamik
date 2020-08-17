<?php

use Slim\Views\Twig;
use App\TwigExtension;
use App\Models\Setting;
use Slim\Flash\Messages;
use Slim\Routing\RouteParser;
use Slim\Views\TwigMiddleware;

/*
|--------------------------------------------------------------------------
| Get the container instance
|--------------------------------------------------------------------------
|*/

$container = $app->getContainer();

/*
|--------------------------------------------------------------------------
| Insert route parser to the container
|--------------------------------------------------------------------------
| This will be used for getting urlFor method at functions.php
|*/
$container->set('routeParser', new RouteParser($app->getRouteCollector()));

/*
|--------------------------------------------------------------------------
| Insert flash message to the container
|--------------------------------------------------------------------------
| 
|*/
$container->set('flash', function () {
    return new Messages();
});

/*
|--------------------------------------------------------------------------
| Including twig to the container
|--------------------------------------------------------------------------
|*/
$container->set('view', function ($container) {
    $twig = Twig::create(__DIR__ . '/../views/', [
        // 'cache' => $container->get('STORAGE_PATH') . '/cache/views'
    ]);

    $ext = new TwigExtension;
    $ext->setContainer($container);
    $twig->addExtension($ext);

    return $twig;
});

$container->set('app', $app);

$app->add(TwigMiddleware::createFromContainer($app));

/*
|--------------------------------------------------------------------------
| Database container setting
|--------------------------------------------------------------------------
| Here we load the database configuration from 'configs/database.php'
| After that, we instantiate the capsule and start connection to the database
|*/
$container->set('settings.database', require __DIR__ . '/../configs/database.php');

$container->set('db', function ($container) {
    $con = null;

    try {
        $settings = $container->get('settings.database');
        $info = sprintf("%s:host=%s;dbname=%s;charset=%s", $settings['driver'], $settings['host'], $settings['database'], $settings['charset']);

        $con = new PDO(
            $info,
            $settings['username'],
            $settings['password']
        );
    } catch (PDOException $e) {
        print "Error!:" . $e->getMessage();
        die;
    } finally {
        return $con;
    }
});

/*
|--------------------------------------------------------------------------
| Settings from database
|--------------------------------------------------------------------------
| Here we store setting from database into container
|*/
// $container->set('settings', function ($container) {
//     return Setting::whereIn('setting_name', require __DIR__ . '/../configs/settings.php')->get()->keyBy('setting_name');
// });
