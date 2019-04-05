<?php declare(strict_types=1);

namespace App\System;

use App\Exceptions\ApplicationException;
use League\Route\{Strategy\JsonStrategy};
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use Throwable;

class ApplicationStrategy extends JsonStrategy
{
    /**
     * {@inheritdoc}
     */
    public function getThrowableHandler() : MiddlewareInterface
    {
        return new class($this->responseFactory->createResponse()) implements MiddlewareInterface
        {
            protected $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $requestHandler
            ) : ResponseInterface {
                try {
                    return $requestHandler->handle($request);
                } catch (ApplicationException $exception) {
                    $response = $this->response;

                    $response->getBody()->write(json_encode([
                        'errors' => $exception->getErrors(),
                    ]));

                    $response = $response->withAddedHeader('content-type', 'application/json');
                    return $response->withStatus($exception->getHttpCode());
                } catch (Throwable $exception) {
                    $response = $this->response;

                    $response->getBody()->write(json_encode([
                        'status_code'   => 500,
                        'reason_phrase' => $exception->getMessage(),
                    ]));

                    $response = $response->withAddedHeader('content-type', 'application/json');
                    return $response->withStatus(500, strtok($exception->getMessage(), "\n"));
                }
            }
        };
    }
}
