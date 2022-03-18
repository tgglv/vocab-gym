<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use Slim\Routing\RouteContext;

class SubmitAttemptAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route        = $routeContext->getRoute();
        $id           = $route->getArgument('id');

        // TODO: Submit Attempt
        return $this->respondWithData( null, 204 );
    }
}
