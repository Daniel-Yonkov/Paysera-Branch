<?php

use PHPUnit\Framework\TestCase;
use Paysera\Branch\Input;
use Paysera\Branch\Parsers\CLIParser;

class InputTest extends TestCase
{
	public function test_getData_returns_multidimensional_array()
	{
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
		$this->assertSame(Input::data($data,(new CLIParser)),$result);
	}
}