<?php

namespace App\Providers;

use App\Rules\StringRule;
use Illuminate\Container\Container;
use Rakit\Validation\Validator;

class RulesServiceProvider
{
    public static function provide()
    {
        $container = Container::getInstance();

        $container->bind(Validator::class, function () use ($container) {
            $validator = new Validator();

            $validator->addValidator('string', new StringRule());

            return $validator;
        });
    }
}
