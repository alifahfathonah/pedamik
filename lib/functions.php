<?php

use Slim\Psr7\Factory\RequestFactory;
use Slim\Psr7\Request;

if (!function_exists('route')) {
    function route(string $routeName, array $data = [], array $params = [])
    {
        global $app;

        return $app->getContainer()->get('routeParser')->urlFor($routeName, $data, $params);
    }
}

if (!function_exists('url_segment')) {
    function url_segment(int $segment = 0)
    {
        global $app;
        $request = $app->getContainer()->get('request');
        $path = $request->getUri()->getPath();
        $uri = substr($path, 1,  strlen($path) - 1);

        return explode('/', $uri)[$segment];
    }
}

if (!function_exists('setting')) {
    function setting(string $settingName, bool $resultAsCollection = false)
    {
        global $app;

        try {
            $setting = $app->getContainer()->get('settings')[$settingName];
            if (!$resultAsCollection) $setting = $setting->setting_value;
            return $setting;
        } catch (\Exception $error) {
            die($error->getMessage());
        }
    }
}
