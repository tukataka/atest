<?php

namespace App\Repositories\Interfaces;

use App\Models\DocumentModel;

interface IDocumentRepository
{
    /**
     * @param DocumentModel $documentModel
     */
    public function add(DocumentModel $documentModel): void;

    /**
     * @param int $id
     *
     * @return DocumentModel
     */
    public function get(int $id): ?DocumentModel;

    /**
     * @param int $id
     */
    public function remove(int $id): void;
}
