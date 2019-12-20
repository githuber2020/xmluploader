<?php
namespace My\Service;

use My\Model\PartialReaderInterface;
use My\Repository\RecordRepositoryInterface;

class XmlToMysqlUploaderService
{
    /**
     * @var RecordRepositoryInterface
     */
    protected $recordRepository;

    /**
     * @var PartialReaderInterface
     */
    protected $xmlReader;

    /**
     * @var int Limit of values in one insert to MySql
     */
//    protected $partialLimit = 1000;
    protected $partialLimit = 10;

    /**
     * Injection of dependencies
     *
     * @param PartialReaderInterface $readerObj
     * @param RecordRepositoryInterface $repositoryObj
     *
     * @return void
     */
    public function __construct(PartialReaderInterface $readerObj, RecordRepositoryInterface $repositoryObj)
    {
        $this->recordRepository = $repositoryObj;
        $this->xmlReader = $readerObj;
    }

    /**
     * Upload records from xml to mySql
     *
     * @param string $filePath
     *
     * @return void
     */
    public function upload($filePath)
    {
        $this->xmlReader->initWithFilePath($filePath);

//        do {
            $recordCollection = $this->xmlReader->readCollectionWithLimit($this->partialLimit);
            $this->recordRepository->saveCollection($recordCollection);
//        } while ($recordCollection);
    }

}