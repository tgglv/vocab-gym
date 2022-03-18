<?php

declare(strict_types=1);

namespace App\Application\Actions\Attempt;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;

class CreateAttemptAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // TODO: add repositories for each entity: Topic, Attempt, Results
        // TODO: create a class for each action in src/Application/{Attempt, Result, Topic}
        // TODO: Create an attempt
        $data = [ 'id' => time() ];
        return $this->respondWithData( $data, 201 );
    }
}
