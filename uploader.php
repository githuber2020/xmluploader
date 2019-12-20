<?php

require_once 'vendor/autoload.php';

use My\Service\XmlToMysqlUploaderService;
use My\Model\XmlRecordReader;
use My\Repository\RecordRepository;

try {

    $uploader = new XmlToMysqlUploaderService(new XmlRecordReader(), new RecordRepository());
    $uploader->upload('xml/17.1-EX_XML_EDR_UO_16.12.2019.xml');

} catch (\Throwable $e) {
    echo 'Something wrong' . $e->getMessage();
}