<?php

declare(strict_types=1);

namespace App\Domain\Attempt;

use JsonSerializable;

class AttemptAnswer implements JsonSerializable
{
    private int $attemptId;

    private int $questionId;

    private string $question;

    private string $correctAnswer;

    private string $answer;

    private bool $isCorrect;

    public function __construct( 
        int $attemptId, 
        int $questionId, 
        string $question,
        string $correctAnswer, 
        string $answer, 
        bool $isCorrect
    ) {
        $this->attemptId     = $attemptId;
        $this->questionId    = $questionId;
        $this->question      = $question;
        $this->correctAnswer = $correctAnswer;
        $this->answer        = $answer;
        $this->isCorrect     = (bool) $isCorrect;
    }

    public function getAttemptId(): int
    {
        return $this->attemptId;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'attemptId'     => $this->attemptId,
            'questionId'    => $this->questionId,
            'question'      => $this->question,
            'correctAnswer' => $this->correctAnswer,
            'answer'        => $this->answer,
            'isCorrect'     => $this->isCorrect,
        ];
    }
}
