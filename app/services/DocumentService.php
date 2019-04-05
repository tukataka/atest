<?php

namespace App\Services;

use App\Models\DocumentModel;
use App\Repositories\Interfaces\IDocumentIndexRepository;
use App\Repositories\Interfaces\IDocumentRepository;
use App\Services\Interfaces\IDocumentService;

class DocumentService implements IDocumentService
{
    private $documentRepository;

    private $documentIndexRepository;

    public function __construct(
        IDocumentRepository $documentRepository,
        IDocumentIndexRepository $documentIndexRepository
    ) {
        $this->documentRepository      = $documentRepository;
        $this->documentIndexRepository = $documentIndexRepository;
    }

    public function add(int $id, string $text): void
    {
        $oldModel = $this->get($id);
        if ($oldModel !== null) {
            $this->documentIndexRepository->remove($oldModel);
        }

        $model = (new DocumentModel())
            ->setId($id)
            ->setText($text);

        $this->documentRepository->add($model);

        $this->documentIndexRepository->add($model);
    }

    public function get(int $id): ?DocumentModel
    {
        return $this->documentRepository->get($id);
    }

    public function delete(int $id): void
    {
        $model = $this->get($id);

        if ($model === null) {
            return;
        }

        $this->documentRepository->remove($id);

        $this->documentIndexRepository->remove($model);
    }
}
