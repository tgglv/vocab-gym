<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Topic;

use App\Domain\Topic\TopicRepositoryInterface;
use App\Domain\Topic\Topic;

class TopicRepository implements TopicRepositoryInterface {
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct( \PDO $pdo ) {
        $this->pdo = $pdo;
    }
    
    /**
     * @return Topic[]
     */
    public function fetchAll(): array {
        // TODO: fix inability to ask MySQL via PDO from REST API

        $sth = $this->pdo->prepare( 'SELECT * FROM topics' );
        $sth->execute();

        $result = [];
        $data = $sth->fetchAll( \PDO::FETCH_NUM );
        foreach ( $data as [ $id, $name, $method, $is_completed ] ) {
            $result[] = new Topic( (int) $id, $name, $method, (bool) $is_completed );
        }

        return $result;
    }
}