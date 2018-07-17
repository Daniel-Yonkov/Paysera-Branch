<?php
namespace Paysera\Branch\Output;

class CLIReport implements Reportable
{
	protected $resource;
	public function __construct($resource){
		$this->resource = $resource;
	}
	public function print($input)
	{	
		$input = implode(PHP_EOL,$input);
		fwrite($this->resource,$input);
	}
}