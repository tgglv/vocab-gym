<?php

declare(strict_types=1);

namespace App\Domain\Topic;

interface TopicRepositoryInterface {
    /**
     * @return Topic[]
     */
    public function fetchAll(): array;
}