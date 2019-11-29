<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';
require_once __DIR__ . '/App/routes.php';

$app->run();