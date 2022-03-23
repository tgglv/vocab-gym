<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

use App\Application\Actions\Action;
use App\Domain\Attempt\AttemptAnswer;
use App\Domain\Attempt\AttemptRepositoryInterface;
use App\Domain\Question\QuestionRepositoryInterface;
use App\Domain\Topic\TopicRepositoryInterface;


class SubmitAttemptAction extends Action
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
     * Submit an attempt
     * 
     * PUT /attempts/:id
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $attemptId    = $route->getArgument('id');

        $attempt = $this->attemptRepository->fetchById( (int) $attemptId );
        if ( false === $attempt ) {
            return $this->respondWithData( [ 'error' => 'Attempt not found' ], 404 );
        }

        $topic = $this->topicRepository->fetchById( $attempt->getTopicId() );
        if ( false === $topic ) {
            return $this->respondWithData( [ 'error' => 'Topic not found' ], 404 );
        }

        // TODO: Add a factory to pick the right answer parser
        if ( 'duplex' !== $topic->getMethod() ) {
            return $this->respondWithData( [ 'error' => 'Method is not supported' ], 400 );
        }

        $body = $this->request->getParsedBody();
        // Duplex-related code        
        $answers = $this->parseDuplexToAnswers( (int) $attemptId, $body );
        $this->attemptRepository->applyAnswers( $answers );

        // TODO: Mark questions as learned if they have N correct answers in a row

        return $this->respondWithData( null, 204 );
    }

    /**
     * Parse answers according to duplex testing method
     * 
     * @param array $data $answers Attempt answers
     * 
     * @return AttemptAnswer[]
     */
    private function parseDuplexToAnswers( int $attemptId, array $data ): array {
        $innerData = []; // [ questionID => [ question2answer => value, answer2question => value ] ]
        foreach ( $data as $item ) {
            if ( empty( $item['id'] ) || empty( $item['approach'] ) || ! isset( $item['a'] ) ) {
                continue;
            }
            if ( ! in_array( $item['approach'], [ 'q2a', 'a2q' ], true ) ) {
                continue;
            }
            $innerData[ $item['id'] ][ $item['approach'] ] = $item['a'];
        }
        $result = [];
        foreach ( $innerData as $questionId => $duplexAnswer ) {
            $question = $this->questionRepository->fetchById( $questionId );
            if ( false === $question ) {
                continue; // question not found
            }
            $q2a = $duplexAnswer['q2a'] ?? null; // Answer for an initial question
            $a2q = $duplexAnswer['a2q'] ?? null; // Question answered from an answer

            $result[] = new AttemptAnswer(
                $attemptId, 
                (int) $questionId,
                $question->getQuestion(),
                $question->getCorrectAnswer(),
                serialize( $duplexAnswer ),
                $question->getQuestion() === $a2q && $question->getCorrectAnswer() === $q2a
                // IDEA: Make isCorrect a calculated field
            );
        }
        return $result;
    }
}
