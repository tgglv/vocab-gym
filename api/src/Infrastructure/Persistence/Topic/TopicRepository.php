<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Topic;

use App\Infrastructure\Persistence\BaseRepository;
use App\Domain\Topic\TopicRepositoryInterface;
use App\Domain\Topic\Topic;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface {
    /**
     * Fetch all topics
     * 
     * @return Topic[]
     */
    public function fetchAll(): array {
        $sth = $this->pdo->prepare( 'SELECT * FROM topics' );
        $sth->execute();

        $result = [];
        $data = $sth->fetchAll( \PDO::FETCH_NUM );
        foreach ( $data as [ $id, $name, $method, $isCompleted, $questionsPerAttempt ] ) {
            $result[] = new Topic(
                (int) $id, 
                $name, 
                $method, 
                (bool) $isCompleted, 
                (int) $questionsPerAttempt
            );
        }

        return $result;
    }

    /**
     * Fetch a topic by ID
     * 
     * @param int $topicId Topic ID
     * 
     * @return ?Topic
     */
    public function fetchById( int $topicId ): ?Topic {
        $sth = $this->pdo->prepare( 'SELECT * FROM topics WHERE id = :topicId' );
        $sth->execute( [ 'topicId' => $topicId ] );

        $result = [];
        $data = $sth->fetchAll( \PDO::FETCH_NUM );
        foreach ( $data as [ $id, $name, $method, $isCompleted, $questionsPerAttempt ] ) {
            return new Topic(
                (int) $id, 
                $name, 
                $method, 
                (bool) $isCompleted, 
                (int) $questionsPerAttempt
            );
        }

        return null;
    }
}