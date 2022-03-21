<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

use App\Application\Actions\Action;
use App\Domain\Attempt\AttemptRepositoryInterface;
use App\Domain\Question\QuestionRepositoryInterface;
use App\Domain\Topic\TopicRepositoryInterface;

class GetAttemptAction extends Action
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
     * Get attempt related data
     * 
     * GET /attempts/:id
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $attemptId    = $route->getArgument('id');

        $attempt = $this->attemptRepository->fetchById( (int) $attemptId );
        if ( null === $attempt ) {
            // An attempt is not found
            return $this->respondWithData( ['error' => 'An attempt is not found'], 404 );
        }

        $topic = $this->topicRepository->fetchById( $attempt->getTopicId() );

        $attemptAnswers = $this->attemptRepository->getAttemptAnswers( $attempt );

        $questions = [];
        foreach ( $attemptAnswers as $answer ) {
            $questions[] = [
                'q'  => $answer->getQuestion(),
                'a'  => $answer->getCorrectAnswer(),
                'id' => $answer->getQuestionId(),
            ];
        }
        $data = [
            'testType'  => $topic->getMethod(),
            'questions' => $questions,
        ];

        return $this->respondWithData( $data, 200 );
    }
}
