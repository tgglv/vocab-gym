<?php

declare(strict_types=1);

namespace App\Domain\Question;

use JsonSerializable;

class Question implements JsonSerializable
{
    private int $id;

    private int $topicId;

    private string $question;

    private string $correctAnswer;

    private bool $isLearned;

    public function __construct(
        int $id, 
        int $topicId,
        string $question,
        string $correctAnswer,
        bool $isLearned
    ) {
        $this->id            = $id;
        $this->topicId       = $topicId;
        $this->question      = $question;
        $this->correctAnswer = $correctAnswer;
        $this->isLearned     = (bool) $isLearned;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTopicId(): int
    {
        return $this->topicId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }
    
    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function isLearned(): bool
    {
        return $this->isLearned;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'topicId'       => $this->topicId,
            'question'      => $this->question,
            'correctAnswer' => $this->correctAnswer,
            'isLearned'     => $this->isLearned,
        ];
    }
}
