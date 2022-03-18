<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use Slim\Routing\RouteContext;

class GetAttemptAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $id           = $route->getArgument('id');

        // TODO: get relevant data from the DB
        $data = [
            'testType'  => 'back-and-forth',
            'questions' => [
                [
                    'q'  => 'abrir',
                    'a'  => 'to open',
                    'id' => 1,
                ],
                [
                    'q'  => 'acabar',
                    'a'  => 'to finish',
                    'id' => 2,
                ],
                [
                    'q'  => 'aceitar',
                    'a'  => 'to accept',
                    'id' => 3,
                ],
            ],
        ];

        return $this->respondWithData( $data, 200 );
    }
}
