<?php

declare(strict_types=1);

namespace App\Domain\Topic;

use JsonSerializable;

class Topic implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $method;

    private bool $is_completed;

    public function __construct(?int $id, string $name, string $method, bool $is_completed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->method = strtolower( $method );
        $this->is_completed = (bool)$is_completed;
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
        return $this->is_completed;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'method' => $this->method,
            'is_completed' => $this->is_completed,
        ];
    }
}
