<?php

use DI\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;


require __DIR__ . '/../vendor/autoload.php';
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
########## DATABASE


$container->set('db', function () {


});

$container->set('vkApi', function () {
    $vkApi = new \App\Api\VkApi\VkApi();
    return $vkApi;
});









