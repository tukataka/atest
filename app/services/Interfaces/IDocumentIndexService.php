<?php

namespace App\Services\Interfaces;

use App\Models\DocumentModel;

interface IDocumentIndexService
{
    /**
     * @param string $word
     *
     * @return array
     */
    public function search(string $word): array;

    /**
     * @param array $words
     *
     * @return array
     */
    public function searchByWords(array $words): array;
}
