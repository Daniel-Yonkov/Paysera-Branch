<?php

use PHPUnit\Framework\TestCase;
use Paysera\Branch\Controllers\TransactionController;
use Paysera\Branch\Converters\EuroConverter;
use Paysera\Branch\Output\CLIReport;
use Paysera\Branch\Parsers\CLIParser;

class ReportTest extends TestCase
{
	// public function test_prints_data()
	// {
	// 	$result ="0.06".PHP_EOL."0.90".PHP_EOL."0".PHP_EOL.
	// 			 "0.70".PHP_EOL."0.30".PHP_EOL."0.30".PHP_EOL.
	// 			 "5.00".PHP_EOL."0.00".PHP_EOL."0.00";
	// 	//expecting the result
	// 	$this->expectOutputString($result);
	// 	//generating the output
	// 	//main report builder class
	// 	$controller = new TransactionController();
	// 	//we setup the converter for the currency we want to check the limit per week
	// 	$controller->setConverter(new EuroConverter());
	// 	$result = $controller->run('example.csv',new CLIParser());
	// 	$report = new CLIReport(STDOUT);
	// 	$report->print($result);
	// }
}