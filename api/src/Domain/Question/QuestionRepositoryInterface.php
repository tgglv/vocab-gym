<?php

declare(strict_types=1);

namespace App\Domain\Question;

use App\Domain\Topic\Topic;

interface QuestionRepositoryInterface {
    /**
     * Fetch IDs of active questions for the topic
     * 
     * @param Topic $topic
     * 
     * @return int[]
     */
    public function fetchActiveQuestionIDs( Topic $topic ): array;

    /**
     * Fetch a question by ID
     * 
     * @param int $questionId Question ID
     * 
     * @return ?Question
     */
    public function fetchById( int $questionId ): ?Question;
}