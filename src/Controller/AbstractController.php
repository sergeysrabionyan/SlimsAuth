<?php


namespace App\Controller;

use App\Api\YandexApi\YandexApi;
use App\Models\Articles;
use App\Models\Users;
use App\Services\UsersAuthService;
use DI\Container;
use Doctrine\DBAL\Connection;
use App\Api\VkApi\VkApi;
use Twig\Environment;

abstract class AbstractController
{
    /**
     * @var VkApi
     */
    protected $vk;
    /**
     * @var Environment $view
     */
    protected $view;
    /**
     * @var Connection $db
     */
    protected $db;
    protected $container;
    protected $users;
    protected $user;
    /**
     * @var YandexApi $yandex
     */
    protected $yandex;

    public function __construct(Articles $articles, Container $container, VkApi $vkApi, Users $users, YandexApi $yandex)
    {
        $this->articles = $articles;
        $this->yandex = $yandex;
        $this->view = $container->get('view');
        $this->vk = $vkApi;
        $this->db = $container->get('db');
        $this->container = $container;
        $this->users = $users;
        $this->user = UsersAuthService::getUserByToken($this->users);
    }
}