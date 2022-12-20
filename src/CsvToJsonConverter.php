<?php

namespace CsvConverter;

use CsvConverter\Helper\CSVProcessor;

class CsvToJsonConverter
{
    /**
     * @var CSVProcessor
     */
    private CSVProcessor $CSVProcessor;

    /**
     * @param CSVProcessor $CSVProcessor
     */
    public function __construct(CSVProcessor $CSVProcessor)
    {
        $this->CSVProcessor = $CSVProcessor;
    }

    /**
     * @param string $csvPath
     * @param string $jsonPath
     * @return void
     */
    public function convertCsvToJson(string $csvPath, string $jsonPath):void
    {
        $csvDataFlat = $this->CSVProcessor->getAssocArrayFromCSV($csvPath);
        $csvDataNested = [];

        foreach ($csvDataFlat as $index => $csvDataFlatRow)
        {
            $csvDataNested[$index] = [];
            foreach ($csvDataFlatRow as $combinedKey => $value) {
                if(!empty($value)) {
                    if($value === "true" || $value === "TRUE"){
                        $value = true;
                    }
                    if($value === "false" || $value === "FALSE"){
                        $value = false;
                    }
                    $separateKeys = explode("__", $combinedKey);
                    $this->convertCombinedKeyToNested($csvDataNested[$index], $separateKeys, 0, $value);
                }
            }
        }
        $json = json_encode($csvDataNested, JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);

        file_put_contents($jsonPath, $json);
    }

    /**
     * @param array $resultArray
     * @param array $separateKeys
     * @param int $currentIndex
     * @param mixed $value
     * @return void
     */
    private function convertCombinedKeyToNested(array &$resultArray, array $separateKeys, int $currentIndex, $value):void
    {
        if ($currentIndex == count($separateKeys) - 1)
        {
            $resultArray[$separateKeys[$currentIndex]] = $value;
        }
        else
        {
            if (!isset($resultArray[$separateKeys[$currentIndex]]))
            {
                $resultArray[$separateKeys[$currentIndex]] = array();
            }

            $this->convertCombinedKeyToNested(
                $resultArray[$separateKeys[$currentIndex]],
                $separateKeys,
                ++$currentIndex,
                $value);
        }
    }
}