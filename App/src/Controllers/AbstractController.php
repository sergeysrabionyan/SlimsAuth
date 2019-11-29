<?php


namespace Src\Controllers;


use Api\VkApi\VkApi;

abstract class AbstractController
{
    protected $vk;
    protected $view;

    public function __construct(VkApi $vkApi)
    {

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../../templates');
        $twig = new \Twig\Environment($loader, ['cache' => false]);
        $this->view = $twig;
        $this->vk = $vkApi;
    }
}