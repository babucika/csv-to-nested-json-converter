<?php
require "./vendor/autoload.php";

use CsvConverter\Helper\CSVProcessor as CSVProcessor;
use CsvConverter\CsvToJsonConverter as Converter;

$csvPath = $argv[1];
$jsonPath = $argv[2];
$separator = $argv[3];

$csvProcessor = new CSVProcessor();
$converter = new Converter($csvProcessor);

$converter->convertCsvToJson($csvPath, $jsonPath, $separator);
