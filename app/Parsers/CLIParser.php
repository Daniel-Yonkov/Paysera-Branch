<?php
namespace Paysera\Branch\Parsers;

class CLIParser implements Parser 
{
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
		return array_map([STATIC::CLASS,'parse'],$file);
	}
	/**
	 * Parses the provided csv file into multidimensional array with parent array = row, child array = value
	 * @param array $value - readed file 
	 * @return array multidimensional
	 */
	protected function parse($value)
	{
		return explode(',',$value);
	}
}