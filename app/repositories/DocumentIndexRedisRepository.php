<?php

namespace App\Repositories;

use App\Exceptions\InternalServerErrorException;
use App\Models\DocumentModel;
use App\Repositories\Interfaces\IDocumentIndexRepository;
use Redis;

class DocumentIndexRedisRepository implements IDocumentIndexRepository
{
    private $redisClient;

    private $documentIndexDatabaseId;

    public function __construct(Redis $redis, string $documentIndexDatabaseId)
    {
        $this->redisClient             = $redis;
        $this->documentIndexDatabaseId = $documentIndexDatabaseId;
    }

    /**
     * @throws InternalServerErrorException
     */
    private function setRedisDatabase()
    {
        $result = $this->redisClient->select($this->documentIndexDatabaseId);

        if (!$result) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * @param DocumentModel $model
     *
     * @throws InternalServerErrorException
     */
    public function add(DocumentModel $model): void
    {
        $this->setRedisDatabase();

        $words = explode(' ', $model->getText());

        foreach ($words as $word) {
            $this->redisClient->sAdd($word, $model->getId());
        }
    }

    /**
     * @param DocumentModel $model
     *
     * @throws InternalServerErrorException
     */
    public function remove(DocumentModel $model): void
    {
        $this->setRedisDatabase();

        $words = explode(' ', $model->getText());

        foreach ($words as $word) {
            $this->redisClient->sRemove($word, $model->getId());
        }
    }

    /**
     * @param string $word
     *
     * @return array
     * @throws InternalServerErrorException
     */
    public function getByWord(string $word): array
    {
        $this->setRedisDatabase();

        return $this->redisClient->sMembers($word);
    }
}
