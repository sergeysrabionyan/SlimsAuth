<?php

use DI\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();


$container->set('vkApi', function () {
    $vkApi = new Api\VkApi\VkApi();
    return $vkApi;
});









