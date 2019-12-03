<?php
require_once __DIR__ . '/../bootstrap/app.php';

$app->get('/', \App\Controller\AuthController::class . ':login');
$app->get('/home', \App\Controller\HomeController::class);
$app->get('/register', \App\Controller\RegisterController::class . ':auth');
$app->post('/register', \App\Controller\RegisterController::class . ':registration');
$app->post('/login', \App\Controller\AuthController::class . ':auth');
$app->get('/vkAuth[/{code:.*}]', \App\Controller\RegisterController::class . ':vkAuth');
$app->get('/yandexAuth[/{code:.*}]', \App\Controller\RegisterController::class . ':yandexAuth');
$app->post('/logout', \App\Controller\AuthController::class . ':logout');