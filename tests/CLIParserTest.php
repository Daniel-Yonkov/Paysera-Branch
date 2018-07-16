<?php

use PHPUnit\Framework\TestCase;
use Paysera\Branch\Parsers\CLIParser;

class CLIParserTest extends TestCase
{
	public function test_getData_parses_string()
	{
		$parser = new CLIParser();
		$data = '2016-01-05,1,natural,cash_in,200.00,EUR';
		$result = array(
			array(
				'date'      	 => '2016-01-05',
				'user_id'   	 => '1',
				'user_type' 	 => 'natural',
				'operation_type' => 'cash_in',
				'amount' 		 =>'200.00',
				'currency' 		 => 'EUR'
			)
		);
		$this->assertSame($parser->getData($data),$result);
	}
	public function test_getData_parses_csv()
	{
		$parser = new CLIParser();
		$result = array(
			array(
				'date'      	 => '2016-01-05',
				'user_id'   	 => '1',
				'user_type' 	 => 'natural',
				'operation_type' => 'cash_in',
				'amount' 		 =>'200.00',
				'currency' 		 => 'EUR'
			)
		);
		$this->assertSame($parser->getData('tests/example.csv'),$result);
	}
}