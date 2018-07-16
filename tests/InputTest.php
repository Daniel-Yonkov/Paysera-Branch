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
				'date'      	 => '2016-01-05',
				'user_id'   	 => '1',
				'user_type' 	 => 'natural',
				'operation_type' => 'cash_in',
				'amount' 		 =>'200.00',
				'currency' 		 => 'EUR'
			)
		);
		$this->assertSame(Input::data($data,(new CLIParser)),$result);
	}
}