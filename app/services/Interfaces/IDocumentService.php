<?php

namespace App\Services\Interfaces;

use App\Models\DocumentModel;

interface IDocumentService
{
    /**
     * @param int $id
     * @param string $text
     */
    public function add(int $id, string $text): void;

    /**
     * @param int $id
     *
     * @return DocumentModel
     */
    public function get(int $id): ?DocumentModel;

    /**
     * @param int $id
     */
    public function delete(int $id): void;
}
