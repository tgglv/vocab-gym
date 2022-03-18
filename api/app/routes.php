<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

use App\Application\Actions\Attempt\CreateAttemptAction;
use App\Application\Actions\Attempt\GetAttemptAction;
use App\Application\Actions\Attempt\GetResultAction;
use App\Application\Actions\Attempt\SubmitAttemptAction;
use App\Application\Actions\Topic\ListTopicsAction;

return function (App $app) {
    // GET /topics
    $app->get( '/topics', ListTopicsAction::class );

    $app->group( '/attempts', function ( Group $group ) {
        // POST /attempts - create a new Attempt
        $group->post( '', CreateAttemptAction::class );

        // GET /attempts/ID - fetch question set by the attempt ID
        $group->get( '/{id}', GetAttemptAction::class );

        // PUT /attempts/ID - submit attempt's answers
        $group->put( '/{id}', SubmitAttemptAction::class );

        // GET /attempts/ID/result - return questions, right/wrong answers
        $group->get( '/{id}/result', GetResultAction::class );
    } );

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });
};
