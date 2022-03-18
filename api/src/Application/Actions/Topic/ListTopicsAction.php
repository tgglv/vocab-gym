<?php

declare(strict_types=1);

namespace App\Application\Actions\Topic;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use Slim\Routing\RouteContext;

class ListTopicsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // TODO: get topics from the DB
        $data = [
            [
                'name' => '100 Verbs for Beginners',
                'id'   => 1,
            ]
        ];

        return $this->respondWithData( $data, 200 );
    }
}
