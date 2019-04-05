<?php

namespace App\Providers;

use App\Repositories\DocumentIndexRedisRepository;
use App\Repositories\DocumentRedisRepository;
use App\Repositories\Interfaces\IDocumentIndexRepository;
use App\Repositories\Interfaces\IDocumentRepository;
use Illuminate\Container\Container;
use Redis;

class RepositoriesServiceProvider
{
    public static function provide()
    {
        $container = Container::getInstance();

        $container->bind(IDocumentRepository::class, function () use ($container) {
            return new DocumentRedisRepository(
                $container->get(Redis::class),
                env('REDIS_DOCUMENT_DATABASE')
            );
        });

        $container->bind(IDocumentIndexRepository::class, function () use ($container) {
            return new DocumentIndexRedisRepository(
                $container->get(Redis::class),
                env('REDIS_DOCUMENT_INDEX_DATABASE')
            );
        });
    }
}
