<?php

namespace App\Repositories;

use App\Exceptions\InternalServerErrorException;
use App\Exceptions\NotFoundException;
use App\Models\DocumentModel;
use App\Repositories\Interfaces\IDocumentRepository;
use Redis;

class DocumentRedisRepository implements IDocumentRepository
{
    private $redisClient;

    private $documentDatabaseId;

    private $redisDocumentKey = 'document_%d';

    public function __construct(Redis $redis, string $documentDatabaseId)
    {
        $this->redisClient        = $redis;
        $this->documentDatabaseId = (int) $documentDatabaseId;
    }

    /**
     * @throws InternalServerErrorException
     */
    private function setRedisDatabase()
    {
        $result = $this->redisClient->select($this->documentDatabaseId);

        if (!$result) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * @param int $id
     *
     * @return string
     */
    private function getCacheKeyForId(int $id): string
    {
        return sprintf($this->redisDocumentKey, $id);
    }

    /**
     * @param DocumentModel $documentModel
     *
     * @throws InternalServerErrorException
     */
    public function add(DocumentModel $documentModel): void
    {
        $this->setRedisDatabase();

        $result = $this->redisClient->set(
            $this->getCacheKeyForId($documentModel->getId()),
            $documentModel->getText()
        );

        if (!$result) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * @param int $id
     *
     * @return DocumentModel|null
     * @throws InternalServerErrorException
     */
    public function get(int $id): ?DocumentModel
    {
        $this->setRedisDatabase();

        $text = $this->redisClient->get(
            $this->getCacheKeyForId($id)
        );

        if ($text === false) {
            return null;
        }

        return (new DocumentModel())
            ->setId($id)
            ->setText($text);
    }

    /**
     * @param int $id
     *
     * @throws InternalServerErrorException
     */
    public function remove(int $id): void
    {
        $this->setRedisDatabase();

        $this->redisClient->delete(
            $this->getCacheKeyForId($id)
        );
    }
}
