<?php

namespace App\Services;

use App\Repositories\Interfaces\IDocumentIndexRepository;
use App\Services\Interfaces\IDocumentIndexService;
use App\Services\Interfaces\IDocumentService;

class DocumentIndexService implements IDocumentIndexService
{
    private $documentIndexRepository;

    private $documentService;

    public function __construct(IDocumentIndexRepository $documentIndexRepository, IDocumentService $documentService)
    {
        $this->documentIndexRepository = $documentIndexRepository;
        $this->documentService         = $documentService;
    }

    /**
     * @param string $word
     *
     * @return array
     */
    public function search(string $word): array
    {
        return array_map(function (int $documentId) {
            return $this->documentService->get($documentId);
        }, $this->documentIndexRepository->getByWord($word));
    }

    /**
     * @param array $words
     *
     * @return array
     */
    public function searchByWords(array $words): array
    {
        $documentsLists = array_map(function (string $word) {
            return $this->documentIndexRepository->getByWord($word);
        }, $words);

        if (count($documentsLists) > 1) {
            $documentsIds = array_values(array_intersect(...$documentsLists));
        } else {
            $documentsIds = reset($documentsLists);
        }

        return array_map(function (int $documentId) {
            return $this->documentService->get($documentId);
        }, $documentsIds);
    }
}
