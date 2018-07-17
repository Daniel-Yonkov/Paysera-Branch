<?php
namespace Paysera\Branch\Taxes;

class DefaultCashOut extends TaxCalc
{
	protected $fee = 0.3;
	protected $number_of_caches = 3;
	protected $limit = 1000;
	protected $limit_currency = 'EUR';
	protected $amountExceeded = 0;
	public function taxes($line)
	{
		$tax = 0;
		if($this->taxingStrategyIsValid($line)) {
			if($this->checkIfAmountExceeds($line)){
				$tax = $this->amountExceeded;
			}
			$tax = ($this->currencyConvert($tax,'EUR',$line['currency'])*$this->fee)/100;
		}
		$this->setTotal($line['user_id'],yearlyWeek($line['date']), $this->amount_in_euro($line['user_id'],yearlyWeek($line['date'])));
		return roundUp($tax,2);
	}
	/**
	 * Checks  if provided amount exceeds the limit and sets by how much
	 * @param array $line
	 * @return bool
	 */
	protected function checkIfAmountExceeds($line)
	{
		$amount = $this->total($line['user_id'],yearlyWeek($line['date']))
			      +
			      $this->amount_in_euro($line['user_id'],yearlyWeek($line['date'])); 
		$tax = ($amount - $this->limit);
		$exceeds = $tax > 0 ? true : false;
		if($exceeds){
			$this->setExceededAmount($tax,$line);
		}
		return $exceeds;
	}
	/**
	 * sets the exceeded amount for the transaction in EUR
	 * @param float $tax - the amount that exceeds the limit 
	 * @param array $line 
	 * @return float
	 */
	public function setExceededAmount($tax,$line)
	{
		$this->amountExceeded = 
				$tax > $this->amount_in_euro($line['user_id'],yearlyWeek($line['date'])) ? 
				$this->amount_in_euro($line['user_id'],yearlyWeek($line['date'])) :
				$tax;
	}
	/**
	 * Rules by which the taxing strategy is applied
	 * @param array $line 
	 * @return bool
	 */
	public function taxingStrategyIsValid($line)
	{
		return ($this->number_of_transactions($line['user_id'],yearlyWeek($line['date'])) > $this->number_of_caches 
			    ||
		       $this->total($line['user_id'],yearlyWeek($line['date']))
		       	+
		       $this->amount_in_euro($line['user_id'],yearlyWeek($line['date'])) > $this->limit
		       ) ? true : false;
	}
}