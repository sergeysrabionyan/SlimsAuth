<?php
require_once __DIR__ . '/../bootstrap/app.php';

$app->get('/', \App\Controller\AuthController::class);
$app->get('/register[/{code:.*}]', \App\Controller\RegisterController::class);
$app->get('/home', \App\Controller\HomeController::class);
