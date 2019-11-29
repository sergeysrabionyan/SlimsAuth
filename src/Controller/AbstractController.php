<?php


namespace App\Controller;


use App\Api\VkApi\VkApi;
use App\DB\Db;
use Doctrine\DBAL\DriverManager;

abstract class AbstractController
{
    protected $vk;
    protected $view;
    protected $db;

    public function __construct(VkApi $vkApi, Db $db)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader, ['cache' => false]);
        $this->view = $twig;
        $this->vk = $vkApi;
        $this->db = new Db();
    }
}