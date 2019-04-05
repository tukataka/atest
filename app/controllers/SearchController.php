<?php

namespace App\Controllers;

use App\Exceptions\BadRequestException;
use App\Models\DocumentModel;
use App\Services\Interfaces\IDocumentIndexService;
use App\Services\Interfaces\IDocumentService;
use Psr\Http\Message\ServerRequestInterface;
use Rakit\Validation\Validator;

class SearchController
{
    private $documentIndexService;

    private $validator;

    public function __construct(Validator $validator, IDocumentIndexService $documentIndexService)
    {
        $this->validator            = $validator;
        $this->documentIndexService = $documentIndexService;
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
        $queryString = $request->getQueryParams()['q'] ?? null;

        $validation = $this->validator->validate([
            'query_string' => $queryString,
        ], [
            'query_string' => 'required|string',
        ]);

        if ($validation->errors()->count() > 0) {
            throw new BadRequestException($validation->errors()->all());
        }

        $words = explode(' ', $queryString);

        return array_map(function (DocumentModel $documentModel) {
            return [
                'id'   => $documentModel->getId(),
            ];
        }, $this->documentIndexService->searchByWords($words));
    }
}
