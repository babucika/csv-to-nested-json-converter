<?php

namespace DataChecker\Helper;

class CSVProcessor
{
    /**
     * @param string $path
     * @return array
     */
    public function getAssocArrayFromCSV(string $path): array
    {
        $rows = $this->getIndexedArrayFromCSV($path);
        $header = array_shift($rows);
        $csv = [];
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        return $csv;
    }

    /**
     * @param string $path
     * @return array
     */
    public function getIndexedArrayFromCSV(string $path): array
    {
        $fp = fopen($path, 'r');
        $array = [];
        while ($row = fgetcsv($fp)) {
            $array[] = $row;
        }
        fclose($fp);

        return $array;
    }
}