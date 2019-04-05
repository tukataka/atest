<?php

namespace App\Repositories\Interfaces;

use App\Models\DocumentModel;

interface IDocumentIndexRepository
{
    /**
     * @param DocumentModel $model
     */
    public function add(DocumentModel $model): void;

    /**
     * @param DocumentModel $model
     */
    public function remove(DocumentModel $model): void;

    /**
     * @param string $word
     *
     * @return array
     */
    public function getByWord(string $word): array;
}
