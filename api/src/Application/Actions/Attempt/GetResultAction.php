<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

use App\Application\Actions\Action;
use App\Domain\Attempt\AttemptRepositoryInterface;
use App\Domain\Topic\TopicRepositoryInterface;

class GetResultAction extends Action
{
    /**
     * @var AttemptRepositoryInterface
     */
    private $attemptRepository;

    /**
     * @var TopicRepositoryInterface
     */
    private $topicRepository;

    public function __construct(
        LoggerInterface $logger,
        AttemptRepositoryInterface $attemptRepository,
        TopicRepositoryInterface $topicRepository
    ) {
        parent::__construct( $logger );
        $this->attemptRepository  = $attemptRepository;
        $this->topicRepository    = $topicRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $attemptId    = $route->getArgument('id');

        $attempt = $this->attemptRepository->fetchById( (int) $attemptId );
        if ( false === $attempt ) {
            return $this->respondWithData( [ 'error' => 'An attempt not found' ], 404 );
        }

        $answers = $this->attemptRepository->getAttemptAnswers( $attempt );
        if ( ! count( $answers ) ) {
            return $this->respondWithData( [ 'error' => 'Answers not found' ], 404 );
        }

        $topic = $this->topicRepository->fetchById( $attempt->getTopicId() );
        if ( false === $attempt ) {
            return $this->respondWithData( [ 'error' => 'A topic not found' ], 404 );
        }

        // TODO: get results
        $data = [
            'topic'   => [
                'id'     => $topic->getId(),
                'name'   => $topic->getName(),
                'method' => $topic->getMethod(),
            ],
            'answers' => array_map( function( $answer ) {
                $answers = unserialize( $answer->getAnswer() );
                return [
                    'id'     => $answer->getQuestionId(),
                    'q'      => $answer->getQuestion(),
                    'a'      => $answer->getCorrectAnswer(),
                    'q2a'    => $answers['q2a'] ?: '---',
                    'a2q'    => $answers['a2q'] ?: '---',
                    'status' => $answer->isCorrect() ? 'correct' : 'incorrect',
                ];
            }, $answers )
        ];

        return $this->respondWithData( $data, 200 );
    }
}
