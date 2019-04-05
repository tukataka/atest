<?php

namespace App\Providers;

use App\Controllers\DeleteController;
use App\Controllers\GetController;
use App\Controllers\SaveController;
use App\Controllers\SearchController;
use App\Services\DocumentService;
use App\Services\Interfaces\IDocumentIndexService;
use Illuminate\Container\Container;
use Rakit\Validation\Validator;

class ControllersServiceProvider
{
    public static function provide()
    {
        $container = Container::getInstance();

        $container->bind(SaveController::class, function () use ($container) {
            return new SaveController(
                $container->get(Validator::class),
                $container->get(DocumentService::class)
            );
        });

        $container->bind(GetController::class, function () use ($container) {
            return new GetController(
                $container->get(Validator::class),
                $container->get(DocumentService::class)
            );
        });

        $container->bind(DeleteController::class, function () use ($container) {
            return new DeleteController(
                $container->get(Validator::class),
                $container->get(DocumentService::class)
            );
        });

        $container->bind(SearchController::class, function () use ($container) {
            return new SearchController(
                $container->get(Validator::class),
                $container->get(IDocumentIndexService::class)
            );
        });
    }
}
