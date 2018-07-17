<?php
namespace Paysera\Branch\Taxes;

class DefaultCashIn extends TaxCalc
{
	protected $fee = 0.03;
	protected $taxLimit = 5;
	public function taxes($line)
	{
		$tax = ($this->fee*$line['amount'])/100;
		if($this->taxLimit < $this->currencyConvert($tax,$line['currency'])){
			$tax = $this->currencyConvert($this->taxLimit,'EUR',$line['currency']);
		}
		return roundUp($tax);
	}
}