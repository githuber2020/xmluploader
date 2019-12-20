<?php
namespace My\Model;

use XMLReader;
use My\Helper\AddressParseHelper;
use My\Model\Exception\ReaderObjectIsNotCreatedException;
use My\Model\Exception\FileNotFoundException;

Class XmlRecordReader implements PartialReaderInterface
{
    /**
     * XML attributes
     */
    const DATA_ATTRIBUTE = 'DATA';
    const START_RECORD_ATTRIBUTE = 'RECORD';
    const ADDRESS_ATTRIBUTE = 'ADDRESS';

    /**
     * @var XMLReader
     */
    protected $reader;

    /**
     * Init reader for file
     *
     * @param string $filePath
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function initWithFilePath($filePath) {

        // TODO file validation
        if (file_exists($filePath)) {
            $this->reader = new XMLReader();
            $this->reader->open($filePath);
        } else {
            throw new FileNotFoundException('File is not found.');
        }
    }

    /**
     * Read collection of record items
     *
     * @param int $limit Numbers of items for partial read
     *
     * @return array
     * @throws ReaderObjectIsNotCreatedException
     */
    public function readCollectionWithLimit($limit) {

        $recordCollection = [];

        do {
            $recordArr = $this->readNextOne();

            if ($recordArr) {
                $recordCollection[] = $this->prepareRecord($recordArr);
            }
        } while (!empty($recordArr) && count($recordCollection) < $limit);

        return $recordCollection;
    }

    /**
     * Read next item from xml file
     *
     * @return array
     */
    public function readNextOne() {

        if (!($this->reader instanceof XMLReader)) {
            throw new ReaderObjectIsNotCreatedException('Reader is not created.');
        }

        $recordArr = [];
        $hasRecordReady = false;

        while ($this->reader->read() && $hasRecordReady === false) {

            if (
                $this->reader->nodeType == XMLReader::ELEMENT
                && $this->reader->localName <> self::DATA_ATTRIBUTE
            ) {

                if ($this->reader->localName == self::START_RECORD_ATTRIBUTE) {
                    $hasRecordReady = !empty($recordArr);
                } else {
                    $recordArr[$this->reader->localName] = $this->reader->readInnerXml();
                }
            }
        }

        return $recordArr;
    }

    /**
     * @param array $recordArr
     */
    protected function prepareRecord(array $recordArr)
    {
        $recordArr[self::ADDRESS_ATTRIBUTE] = (new AddressParseHelper($recordArr[self::ADDRESS_ATTRIBUTE]))->toJsonStr();
        return $recordArr;
    }
}