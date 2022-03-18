<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use Slim\Routing\RouteContext;

class GetResultAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $id           = $route->getArgument('id');

        // TODO: get results
        $data = [
            'topic' => [
                'id' => 1,
                'name' => '100 verbs for beginners',
                'approach' => 'back-and-forth',
            ],
            'answers' => [
                [
                    'id' => 1,
                    'q' => 'abrir',
                    'a' => 'to open',
                    'q2a' => 'open',
                    'a2q' => 'arir',
                    'status' => 'incorrect',
                ],
                [
                    'id' => 2,
                    'q' => 'abrir',
                    'a' => 'to open',
                    'q2a' => 'open',
                    'a2q' => 'arir',
                    'status' => 'incorrect',
                ],
                [
                    'id' => 3,
                    'q' => 'acaitar',
                    'a' => 'to accept',
                    'q2a' => 'to accept',
                    'a2q' => 'aceitar',
                    'status' => 'correct',
                ],
            ],
        ];

        return $this->respondWithData( $data, 200 );
    }
}
