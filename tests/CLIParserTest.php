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
				'2016-01-05',
				'1',
				'natural',
				'cash_in',
				'200.00',
				'EUR'
			)
		);
		$this->assertSame($parser->getData($data),$result);
	}
	public function test_getData_parses_csv()
	{
		$parser = new CLIParser();
		$result = array(
			array(
				'2016-01-05',
				'1',
				'natural',
				'cash_in',
				'200.00',
				'EUR'
			)
		);
		$this->assertSame($parser->getData('tests/example.csv'),$result);
	}
}