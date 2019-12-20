<?php
namespace My\Repository;

interface RecordRepositoryInterface
{
    /**
     * @param array $recordCollection
     */
    public function saveCollection(array $recordCollection);
}