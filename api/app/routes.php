<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Routing\RouteContext;

return function (App $app) {
    // GET /topics
    $app->get( '/topics', function ( Request $request, Response $response ) {
        $data = [
            [
                'name' => '100 Verbs for Beginners',
                'id'   => 1,
            ]
        ];

        $response->getBody()->write( json_encode( $data ) );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } );

    // POST /attempts - create a new attempt, store question set in the DB, return attempt ID
    $app->post( '/attempts', function( Request $request, Response $response ) {
        // TODO: generate an attempt in the DB
        $data = [ 'id' => time() ];

        $response->getBody()->write( json_encode( $data ) );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    } );

    // GET /attempts/ID - fetch question set by the attempt ID
    $app->get( '/attempts/{id}', function( Request $request, Response $response ) {
        $routeContext = RouteContext::fromRequest($request);
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

        $response->getBody()->write( json_encode( $data ) );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } );

    // PUT /attempts/ID - submit attempt's answers
    $app->put( '/attempts/{id}', function( Request $request, Response $response ) {
        $routeContext = RouteContext::fromRequest($request);
        $route        = $routeContext->getRoute();
        $id           = $route->getArgument('id');

        // TODO: save attempt's answers

        return $response->withStatus(204);
    } );

    // GET /attempts/ID/result - return questions, right/wrong answers
    $app->get( '/attempts/{id}/result', function( Request $request, Response $response ) {
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

        $response->getBody()->write( json_encode( $data ) );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
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
