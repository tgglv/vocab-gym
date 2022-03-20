<?php

declare(strict_types=1);

namespace App\Domain\Attempt;

interface AttemptRepositoryInterface {
    /**
     * Create a new attempt
     * 
     * @param int $topicId Topic ID
     * 
     * @return Attempt
     */
    public function registerAttempt( int $topicId ): ?Attempt;

    /**
     * Fill an attempt with questions that will be used in it
     * 
     * @param Attempt $attempt     Attempt
     * @param int[]   $questionIDs List of question IDs to be filled
     */
    public function fillAttemptWithQuestions( Attempt $attempt, array $questionIDs );
}