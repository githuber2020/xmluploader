<?php
namespace My\Repository;

class RecordRepository implements RecordRepositoryInterface
{
    /**
     * @var array Fields of sql row
     */
    protected $fieldsArr = [
        'NAME', 'SHORT_NAME', 'EDRPOU', 'ADDRESS', 'BOSS', 'KVED', 'STAN', 'FOUNDERS', 'FOUNDER'
    ];

    /**
     * @param array $recordCollection
     */
    public function saveCollection(array $recordCollection) {
        if ($recordCollection) {
            $sqlQuery = "INSERT IGNORE INTO records ('" . implode("', '", $this->fieldsArr) . "') VALUES"
                . $this->prepareCollectionValuesQuery($recordCollection) . ";";

            echo "<p>{$sqlQuery}</p>";
            // execute $sqlQuery to MySql
        }
    }

    /**
     * @param array $recordCollection
     */
    protected function prepareCollectionValuesQuery(array $recordCollection) {
        $valuesCollection = [];
        foreach ($recordCollection as $recordArr) {
            $valuesCollection[] = $this->prepareaOneValuesQuery($recordArr);
        }

        return implode(", ", $valuesCollection);
    }

    /**
     * @param array $recordArr
     */
    protected function prepareaOneValuesQuery(array $recordArr) {

        $result = [];

        foreach ($this->fieldsArr as $attrName) {
            // TODO protection from injections and special symbols
            $result[$attrName] = addslashes($recordArr[$attrName]);
        };

        return "('" . implode("', '", $result) . "'')";
    }
}