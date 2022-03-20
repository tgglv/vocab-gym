<?php

declare(strict_types=1);

namespace App\Domain\Topic;

interface TopicRepositoryInterface {
    /**
     * Fetch all topics
     * 
     * @return Topic[]
     */
    public function fetchAll(): array;

    /**
     * Fetch a topic by ID
     * 
     * @param int $topicId Topic ID
     * 
     * @return Topic
     */
    public function fetchById( int $topicId ): ?Topic;
}