<?php
require_once 'vendor/autoload.php';

use Paysera\Branch\Controllers\TransactionController;
use Paysera\Branch\Converters\EuroConverter;
use Paysera\Branch\Parsers\CLIParser;
//main report builder class
$controller = new TransactionController();
//we setup the converter for the currency we want to check the limit per week
$controller->setConverter(new EuroConverter());
//we run the results for the taxes by providing either a csv file or a string and the parser of the file
$result = $controller->run($argv[1],new CLIParser());
