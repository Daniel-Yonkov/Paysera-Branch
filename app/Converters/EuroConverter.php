<?php
namespace Paysera\Branch\Converters;

class EuroConverter extends Converter
{
	public function defineDefaultCurrency()
	{
		return 'EUR';
	}
	public function defineCurrencyRates()
	{
		return array(
				1 => array(
					'JPY' => 129.53,
					'USD' => 1.1497
					),
				);
	}
}