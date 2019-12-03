<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

try {
    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bootstrap/app.php';
    require_once __DIR__ . '/../Configs/routes.php';
    $app->run();
} catch (\App\Exception\NotAuthException $e) {
    $loader = new FilesystemLoader(__DIR__ . '/templates');
    $twig = new Environment($loader, ['cache' => false]);
    echo $twig->render('401.twig');


}