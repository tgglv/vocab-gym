<?php

declare(strict_types=1);

namespace App\Domain\Attempt;

use JsonSerializable;

class Attempt implements JsonSerializable
{
    private int $id;

    private int $topicId;

    private string $dateCreated;

    private bool $isAnswered;

    public function __construct( int $id, int $topicId, string $dateCreated, bool $isAnswered )
    {
        $this->id = $id;
        $this->topicId = $topicId;
        $this->dateCreated = $dateCreated;
        $this->isAnswered = (bool) $isAnswered;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTopicId(): int
    {
        return $this->topicId;
    }

    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    public function getisAnswered(): bool
    {
        return $this->isAnswered;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'topicId' => $this->topicId,
            'dateCreated' => $this->dateCreated,
            'isAnswered' => $this->isAnswered,
        ];
    }
}
