<?php

namespace App\Providers;

use App\Repositories\Interfaces\IDocumentIndexRepository;
use App\Repositories\Interfaces\IDocumentRepository;
use App\Services\DocumentIndexService;
use App\Services\DocumentService;
use App\Services\Interfaces\IDocumentIndexService;
use App\Services\Interfaces\IDocumentService;
use Illuminate\Container\Container;

class ServicesServiceProvider
{
    public static function provide()
    {
        $container = Container::getInstance();

        $container->bind(IDocumentService::class, function () use ($container) {
            return new DocumentService(
                $container->get(IDocumentRepository::class),
                $container->get(IDocumentIndexRepository::class)
            );
        });

        $container->bind(IDocumentIndexService::class, function () use ($container) {
            return new DocumentIndexService(
                $container->get(IDocumentIndexRepository::class),
                $container->get(IDocumentService::class)
            );
        });
    }
}
