<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::create(dirname(__DIR__, 1));
$dotenv->overload();

$dotenv->required([
    'REDIS_HOST',
    'REDIS_PORT',
    'REDIS_DOCUMENT_DATABASE',
    'REDIS_DOCUMENT_INDEX_DATABASE',
])->notEmpty();
