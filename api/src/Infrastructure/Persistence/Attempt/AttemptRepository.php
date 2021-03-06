<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Attempt;

use App\Infrastructure\Persistence\BaseRepository;
use App\Domain\Attempt\Attempt;
use App\Domain\Attempt\AttemptAnswer;
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
        return $this->fetchById( (int) $attemptId );
    }

    /**
     * Fetch an attempt from the DB
     * 
     * @param int $attemptId
     * 
     * @return Attempt
     */
    public function fetchById( int $attemptId ): ?Attempt {
        $stmt = $this->pdo->prepare( 
            'SELECT id, topic_id, date_created, is_answered FROM attempts WHERE id = :id'
        );
        $stmt->bindParam( ':id', $attemptId, \PDO::PARAM_INT );
        $stmt->execute(); 

        $attemptData = $stmt->fetch( \PDO::FETCH_NUM );
        if ( false === $attemptData ) {
            return null;
        }

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

    /**
     * Get attempt answers
     * 
     * @param Attempt $attempt Attempt
     * 
     * @return null|AttemptAnswer[] Attempt answers
     */
    public function getAttemptAnswers( Attempt $attempt ): ?array {
        $stmt = $this->pdo->prepare(
            'SELECT aa.question_id, q.content, q.correct_answer, aa.answer, aa.is_correct 
            FROM attempt_answers aa
            INNER JOIN questions q ON q.id = aa.question_id
            WHERE attempt_id = :attemptId'
        );

        // bindParam uses passing by reference
        $attemptId = $attempt->getId();
        $stmt->bindParam( ':attemptId', $attemptId, \PDO::PARAM_INT );
        $stmt->execute();

        $result  = [];
        $answers = $stmt->fetchAll( \PDO::FETCH_NUM );
        if ( count( $answers ) ) {
            foreach( $answers as [ $questionId, $question, $correctAnswer, $answer, $isCorrect ] ) {
                $result[] = new AttemptAnswer( 
                    (int) $attemptId, 
                    (int) $questionId, 
                    $question, 
                    $correctAnswer, 
                    $answer, 
                    (bool) $isCorrect
                );
            }
        }

        return $result;
    }

    /**
     * Submit answers to an attempt
     * 
     * @param AttemptAnswer[] $answers Attempt answers
     * 
     * @return void
     */
    public function applyAnswers( array $answers ) {
        $values = [];
        foreach( $answers as $a ) {
            // TODO: Protect from SQL injection for the answer
            $values[] = sprintf(
                '(%d, %d, \'%s\', %d)',
                (int) $a->getAttemptId(),
                (int) $a->getQuestionId(),
                addslashes( $a->getAnswer() ),
                (int) $a->isCorrect(),
            );
        }
        $values = implode( ', ', $values );
        $sql = "INSERT INTO attempt_answers ( attempt_id, question_id, answer, is_correct ) VALUES
            {$values} ON DUPLICATE KEY UPDATE answer=VALUES(answer), is_correct=VALUES(is_correct)";
        $this->pdo->query( $sql );
    }
}