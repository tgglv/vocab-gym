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

    /**
     * Fetch an attempt from the DB
     * 
     * @param int $attemptId
     * 
     * @return Attempt
     */
    public function fetchById( int $attemptId ): ?Attempt;

    /**
     * Get attempt answers
     * 
     * @param Attempt $attempt Attempt
     * 
     * @return null|AttemptAnswer[] Attempt answers
     */
    public function getAttemptAnswers( Attempt $attempt ): ?array;

    /**
     * Submit answers to an attempt
     * 
     * @param AttemptAnswer[] $answers Attempt answers
     * 
     * @return void
     */
    public function applyAnswers( array $answers );
}