<?php

declare(strict_types=1);

namespace App\Domain\Topic;

use JsonSerializable;

class Topic implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $method;
    private bool $isCompleted;
    private int  $questionsPerAttempt;

    public function __construct(
        int $id, 
        string $name, 
        string $method, 
        bool $isCompleted, 
        int $questionsPerAttempt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->method = strtolower( $method );
        $this->isCompleted = (bool) $isCompleted;
        $this->questionsPerAttempt = (int) $questionsPerAttempt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getIsCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function getQuestionsPerAttempt(): int
    {
        return $this->questionsPerAttempt;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'method'              => $this->method,
            'isCompleted'         => $this->isCompleted,
            'questionsPerAttempt' => $this->questionsPerAttempt,
        ];
    }
}
