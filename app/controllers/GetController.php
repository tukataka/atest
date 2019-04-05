<?php

namespace App\Controllers;

use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Services\Interfaces\IDocumentService;
use Psr\Http\Message\ServerRequestInterface;
use Rakit\Validation\Validator;

class GetController
{
    private $documentService;

    private $validator;

    public function __construct(Validator $validator, IDocumentService $documentService)
    {
        $this->validator       = $validator;
        $this->documentService = $documentService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, array $args): array
    {
        $validation = $this->validator->validate([
            'id'   => $id = $args['id'],
        ], [
            'id'   => 'required|integer|min:1',
        ]);

        if ($validation->errors()->count() > 0) {
            throw new BadRequestException($validation->errors()->all());
        }

        $model = $this->documentService->get($id);

        if ($model === null) {
            throw new NotFoundException();
        }

        return [
            'id'   => $model->getId(),
            'text' => $model->getText(),
        ];
    }
}
