<?php
namespace Paysera\Branch\Controllers;

use Paysera\Branch\Parsers\Parser;

interface Controller
{
	public function run($data, Parser $parser);
}