<?php

namespace App\Models;

use DI\Container;
use Doctrine\DBAL\Connection;

class Articles
{
    /**
     * @var Connection $db
     */
    protected $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get('db');

    }

    public function findComment($authorId)
    {
        $result = $this->db->fetchAssoc('SELECT * FROM `articles` WHERE `author_id` = ?', [$authorId]);
        return $result;
    }

}