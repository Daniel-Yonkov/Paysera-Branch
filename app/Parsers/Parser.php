<?php
namespace Paysera\Branch\Parsers;
/**
 * Extending this abstract class allows to parse data from different sources 
 * (CSV, XLS, Relation/Document based database, xml, etc).
 * Just create your parsing logic within getData method,
 * based on the received data in the follwing format.
 * Currently it supports hasmap as follows:
 * array(
	array(
		'date'      	 => '2016-01-05',
		'user_id'   	 => '1',
		'user_type' 	 => 'natural',
		'operation_type' => 'cash_in',
		'amount' 		 =>'200.00',
		'currency' 		 => 'EUR'
	)
  );
 */
abstract class Parser
{
	protected $keys = array('date','user_id','user_type','operation_type','amount','currency');
	/**
	 * Array based parsing for CSV files trought CLI
	 * @param string $filename
	 * @return array - multidimensional
	 */
	public function getData($filename)
	{
		$file = $filename;
		if(is_readable($filename)) $file = file_get_contents($filename);
		$file = explode(PHP_EOL,$file);
		return array_map([SELF::CLASS,'parse'],$file);
	}
	/**
	 * Parses the provided csv file into multidimensional array with parent array = row, child array = value
	 * @param array $value - readed file 
	 * @return array multidimensional
	 */
	protected function parse($value)
	{
		$val = explode(',',$value);
		return array_combine($this->keys,array_values($val));
	}
}