<?php declare(strict_types=1);

const ROOT_DIRECTORY = __DIR__;

use App\Providers\ControllersServiceProvider;
use App\Providers\RepositoriesServiceProvider;
use App\Providers\RulesServiceProvider;
use App\Providers\ServicesServiceProvider;
use App\Providers\VendorServiceProvider;
use App\System\ApplicationStrategy;
use Illuminate\Container\Container;
use League\Route\Router;
use Zend\Diactoros\ResponseFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

try {
    include_once 'vendor/autoload.php';
    include_once 'bootstrap/env.php';

    $request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );

    $responseFactory = new ResponseFactory();

    $jsonStrategy = (new ApplicationStrategy($responseFactory));
    $jsonStrategy->setContainer(Container::getInstance());

    $router = (new Router());
    $router->setStrategy($jsonStrategy);

    include_once 'routes.php';

    ControllersServiceProvider::provide();
    RepositoriesServiceProvider::provide();
    RulesServiceProvider::provide();
    ServicesServiceProvider::provide();
    VendorServiceProvider::provide();

    $response = $router->dispatch($request);

    (new SapiEmitter())->emit($response);

} catch (Exception $e) {
    echo $e->getMessage();
}
