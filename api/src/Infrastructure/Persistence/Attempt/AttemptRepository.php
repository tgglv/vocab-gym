<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Attempt;

use App\Infrastructure\Persistence\BaseRepository;
use App\Domain\Attempt\Attempt;
use App\Domain\Attempt\AttemptRepositoryInterface;

class AttemptRepository extends BaseRepository implements AttemptRepositoryInterface {
    /**
     * Create a new attempt
     * 
     * @param int $topicId Topic ID
     * 
     * @return Attempt
     */
    public function registerAttempt( int $topicId ): Attempt {
        $stmt = $this->pdo->prepare( 'INSERT INTO attempts ( topic_id ) VALUE ( :topicId )' );
        $stmt->bindParam( ':topicId', $topicId, \PDO::PARAM_INT );
        $stmt->execute(); 

        $attemptId = $this->pdo->lastInsertId();
        return $this->getAttempt( (int) $attemptId );
    }

    /**
     * Fetch an attempt from the DB
     * 
     * @param int $attemptId
     * 
     * @return Attempt
     */
    public function getAttempt( int $attemptId ): ?Attempt {
        $stmt = $this->pdo->prepare( 
            'SELECT id, topic_id, date_created, is_answered FROM attempts WHERE id = :id'
        );
        $stmt->bindParam( ':id', $attemptId, \PDO::PARAM_INT );
        $stmt->execute(); 

        $attemptData = $stmt->fetch( \PDO::FETCH_NUM );

        // TODO: Handle the case when an attempt is not found

        list( $id, $topicId, $dateCreated, $isAnswered ) = $attemptData;
        return new Attempt(
            (int) $id,
            (int) $topicId,
            date( 'Y-m-d H:i:s', (int) $dateCreated ),
            (bool) $isAnswered
        );
    }

    /**
     * Fill an attempt with questions that will be used in it
     * 
     * @param Attempt $attempt     Attempt
     * @param int[]   $questionIDs List of question IDs to be filled
     */
    public function fillAttemptWithQuestions( Attempt $attempt, array $questionIDs ) {
        $sql = 'INSERT INTO attempt_answers ( attempt_id, question_id ) VALUES ' .
            implode( 
                ', ', 
                array_map(
                    function( $questionId ) use ( $attempt ) {
                        return sprintf( '( %d, %d )', $attempt->getId(), (int) $questionId );
                    }, 
                    $questionIDs
                )
            );
        $this->pdo->query( $sql );
    }
}