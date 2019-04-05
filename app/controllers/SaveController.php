<?php

namespace App\Controllers;

use App\Exceptions\BadRequestException;
use App\Services\Interfaces\IDocumentService;
use Psr\Http\Message\ServerRequestInterface;
use Rakit\Validation\Validator;

class SaveController
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
     *
     * @return array
     * @throws BadRequestException
     */
    public function __invoke(ServerRequestInterface $request, array $args): array
    {
        $inputJson = json_decode($request->getBody()->getContents(), true);

        $validation = $this->validator->validate([
            'id'   => $id = $args['id'],
            'text' => $text = $inputJson,
        ], [
            'id'   => 'required|integer|min:1',
            'text' => 'required|string',
        ]);

        if ($validation->errors()->count() > 0) {
            throw new BadRequestException($validation->errors()->all());
        }

        $this->documentService->add($id, $text);

        return [
            'result' => true,
        ];
    }
}
