<?php
namespace Paysera\Branch;

use Paysera\Branch\Parsers\Parser;

class Input
{
	/**
	 * @var string $data
	 * @return  array $result
	 */
	public static function data($data,Parser $parser) : array
	{
		return $parser->getData($data);
	}
}
