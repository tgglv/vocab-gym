<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use App\Application\Actions\Action;
use App\Domain\Attempt\AttemptRepositoryInterface;
use App\Domain\Question\QuestionRepositoryInterface;
use App\Domain\Topic\TopicRepositoryInterface;

class CreateAttemptAction extends Action
{
    /**
     * @var AttemptRepositoryInterface
     */
    private $attemptRepository;

    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepository;

    /**
     * @var TopicRepositoryInterface
     */
    private $topicRepository;

    public function __construct(
        LoggerInterface $logger,
        AttemptRepositoryInterface $attemptRepository,
        QuestionRepositoryInterface $questionRepository,
        TopicRepositoryInterface $topicRepository
    ) {
        parent::__construct( $logger );
        $this->attemptRepository  = $attemptRepository;
        $this->questionRepository = $questionRepository;
        $this->topicRepository    = $topicRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Check for topicID
        $body = $this->request->getParsedBody();
        if ( empty( $body['topicId'] ) ) {
            return $this->respondWithData( [ 'error' => 'Topic is missed' ], 422 );
        }

        $topicId = (int) $body['topicId'];

        // Try to fetch the topic
        $topic = $this->topicRepository->fetchById( $topicId );
        if ( null === $topic ) {
            return $this->respondWithData( [ 'error' => 'Topic not found' ], 404 );
        }

        // Fetch questions for the attempt
        $activeQuestionIDs = $this->questionRepository->fetchActiveQuestionIDs( $topic );
        if ( $topic->getQuestionsPerAttempt() > count( $activeQuestionIDs ) ) {
            return $this->respondWithData( 
                [ 'error' => 'Topic does not contain enought questions' ], 
                400
            );
        }

        // Create an attempt
        $attempt = $this->attemptRepository->registerAttempt( $topicId );
        // Assign a portion of active questions to the attempt
        $this->attemptRepository->fillAttemptWithQuestions( $attempt, $activeQuestionIDs );

        $data = [ 'id' => $attempt->getId() ];
        return $this->respondWithData( $data, 201 );
    }
}
