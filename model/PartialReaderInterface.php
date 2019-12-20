<?php
namespace My\Model;

interface PartialReaderInterface
{
    /**
     * Init reader for file
     *
     * @param string $filePath
     *
     * @return void
     */
    public function initWithFilePath($filePath);

    /**
     * Read collection of record items
     *
     * @param int $limit Numbers of items for partial read
     *
     * @return array
     */
    public function readCollectionWithLimit($limit);

    /**
     * Read next item from xml file
     *
     * @return array
     */
    public function readNextOne();
}