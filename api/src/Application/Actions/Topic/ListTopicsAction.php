<?php

declare(strict_types=1);

namespace App\Application\Actions\Topic;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use App\Application\Actions\Action;
use App\Domain\Topic\TopicRepositoryInterface;
use Psr\Log\LoggerInterface;

class ListTopicsAction extends Action
{
    /**
     * @var TopicRepositoryInterface
     */
    private $topicRepository;

    public function __construct(LoggerInterface $logger, TopicRepositoryInterface $topicRepository)
    {
        parent::__construct($logger);
        $this->topicRepository = $topicRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->topicRepository->fetchAll();

        return $this->respondWithData( $data, 200 );
    }
}
