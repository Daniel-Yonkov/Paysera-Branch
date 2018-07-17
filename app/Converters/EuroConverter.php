<?php
namespace Paysera\Branch\Converters;

class EuroConverter extends Converter
{
	public function __construct()
	{
		//EUR:USD - 1:1.1497, EUR:JPY - 1:129.53
		$rates = array(
			1 => array(
				'JPY' => 129.53,
				'USD' => 1.1497
			),
		);
		$this->setRates($rates);
	}
}