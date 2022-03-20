<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use App\Domain\Attempt\AttemptRepositoryInterface;
use App\Domain\Question\QuestionRepositoryInterface;
use App\Domain\Topic\TopicRepositoryInterface;
use App\Infrastructure\Persistence\Attempt\AttemptRepository;
use App\Infrastructure\Persistence\Question\QuestionRepository;
use App\Infrastructure\Persistence\Topic\TopicRepository;

// TODO: add repository Results

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        AttemptRepositoryInterface::class  => \DI\autowire( AttemptRepository::class ),
        QuestionRepositoryInterface::class => \DI\autowire( QuestionRepository::class ),
        TopicRepositoryInterface::class    => \DI\autowire( TopicRepository::class ),
    ]);
};
