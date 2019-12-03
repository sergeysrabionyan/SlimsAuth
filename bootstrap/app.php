<?php


use App\Api\VkApi\VkApi;

use App\Api\YandexApi\YandexApi;
use App\Models\Articles;
use DI\Container;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
$container->set('vkApi', new VkApi());

$container->set('yandexApi', new YandexApi());

$container->set('systemLoader', function (Container $container) {
    return new FilesystemLoader(__DIR__ . '/../templates');
});

$Loader = $container->get('systemLoader');

$container->set('view', function (Container $container) {
    return new Environment($container->get('systemLoader'), ['cache' => false]);
});

$container->set('articles', function ($container) {
    return new Articles($container);
});

$container->set('db', function ($container) {
    $config = new \Doctrine\DBAL\Configuration();
    $connectionParams = [
        'host' => $_ENV['HOST'],
        'dbname' => $_ENV['DBNAME'],
        'user' => $_ENV['USER'],
        'password' => $_ENV['PASSWORD'],
        'driver' => $_ENV['DRIVER'],
    ];
    $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    return $conn;
});

$container->set('users', function ($container) {
    return new \App\Models\Users($container);
});









