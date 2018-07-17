<?php
namespace Paysera\Branch\Parsers;
/**
 * Implementing this interface allows to parse data from different sources 
 * (CSV, XLS, Relation/Document based database, xml, etc).
 * Just create your parsing logic within getData method,
 */
interface Parser
{
	
	public function getData($filename);
}