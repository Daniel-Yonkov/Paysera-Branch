<?php
namespace Paysera\Branch\Taxes;

class LegalCashOut extends TaxCalc
{
	protected $fee = 0.3;
	protected $taxLimit = 0.5;
	public function taxes($line)
	{
		$tax = ($this->fee*$line['amount'])/100;
		if($this->taxLimit > $this->currencyConvert($tax,$line['currency'])){
			$tax = $this->currencyConvert($this->taxLimit,'EUR',$line['currency']);
		}
		return roundUp($tax);
	}
}