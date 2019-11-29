<?php
require_once __DIR__ . '/../bootstrap/app.php';

$app->get('/', \Src\Controllers\AuthController::class);
$app->get('/register[/{code:.*}]', \Src\Controllers\Register::class);
$app->get('/home', \Src\Controllers\HomeController::class);
