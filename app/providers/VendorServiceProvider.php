<?php

namespace App\Providers;

use App\Exceptions\InternalServerErrorException;
use Illuminate\Container\Container;
use Redis;

class VendorServiceProvider
{
    public static function provide()
    {
        $container = Container::getInstance();

        $container->bind(Redis::class, function () use ($container) {
            $redis = new Redis();

            $connectResult = $redis->connect(
                env('REDIS_HOST'),
                env('REDIS_PORT')
            );

            if (!$connectResult) {
                throw new InternalServerErrorException();
            }

            return $redis;
        });
    }
}
