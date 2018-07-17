<?php

use PHPUnit\Framework\TestCase;
use Paysera\Branch\Input;
use Paysera\Branch\Output\Report;
use Paysera\Branch\Parsers\CLIParser;

class ReportTest extends TestCase
{
	public function test_prints_data()
	{
		$result ="0.06".PHP_EOL."0.90".PHP_EOL."0".PHP_EOL.
				 "0.70".PHP_EOL."0.30".PHP_EOL."0.30".PHP_EOL.
				 "5.00".PHP_EOL."0.00".PHP_EOL."0.00";
		//expecting the result
		$this->expectOutputString($result);
		//building the input
		$input = Input::data('example.csv',new CLIParser());
		//generating the output
		Report::print($input,STDOUT);
	}
}