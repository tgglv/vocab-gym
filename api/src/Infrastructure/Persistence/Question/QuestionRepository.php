<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Question;

use App\Infrastructure\Persistence\BaseRepository;
use App\Domain\Question\Question;
use App\Domain\Question\QuestionRepositoryInterface;
use App\Domain\Topic\Topic;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface {
    /**
     * Fetch IDs of active questions for the topic
     * 
     * @param Topic $topic Topic
     * 
     * @return int[]
     */
    public function fetchActiveQuestionIDs( Topic $topic ): array {    
        $stmt = $this->pdo->prepare(
            'SELECT id 
            FROM questions 
            WHERE is_learned = 0 
                AND topic_id = :topicId
            ORDER BY id 
            LIMIT :limit'
        );

        // Bind uses passing by reference, so we need to use variables
        $topicId         = $topic->getId();
        $questionsNumber = $topic->getQuestionsPerAttempt();

        $stmt->bindParam( ':topicId', $topicId, \PDO::PARAM_INT );
        $stmt->bindParam( ':limit', $questionsNumber, \PDO::PARAM_INT );
        $stmt->execute(); 

        $result = [];
        $data = $stmt->fetchAll( \PDO::FETCH_NUM );

        return array_values( 
            array_map( 
                function( $row ) {
                    return empty( $row[0] ) ? null : (int) $row[0];
                }, 
                $data 
            )
        );
    }

    /**
     * Fetch a question by ID
     * 
     * @param int $questionId Question ID
     * 
     * @return ?Question
     */
    public function fetchById( int $questionId ): ?Question {
        $stmt = $this->pdo->prepare(
            'SELECT id, topic_id, content, correct_answer, is_learned 
            FROM questions 
            WHERE id = :id'
        );

        $stmt->bindParam( ':id', $questionId, \PDO::PARAM_INT );
        $stmt->execute(); 

        $result = [];
        $data = $stmt->fetch( \PDO::FETCH_NUM );
        if ( false === $data ) {
            return null;
        }

        list( $id, $topicId, $content, $correctAnswer, $isLearned ) = $data;
        return new Question(
            (int) $id,
            (int) $topicId,
            $content,
            $correctAnswer,
            (bool) $isLearned
        );
    }
}