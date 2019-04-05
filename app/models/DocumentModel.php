<?php

namespace App\Models;

class DocumentModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DocumentModel
     */
    public function setId(int $id): DocumentModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return DocumentModel
     */
    public function setText(string $text): DocumentModel
    {
        $this->text = $text;

        return $this;
    }
}
