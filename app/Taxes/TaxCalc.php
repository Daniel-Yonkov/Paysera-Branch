<?php
namespace Paysera\Branch\Taxes;

use Paysera\Branch\Controllers\Controller;
abstract class TaxCalc
{
	private $amount = array();
	public function total($user_id,$date)
	{
		return $this->amount[$user_id][$date]['total'] ?? 0 ;
	}
	public function setTotal($user_id,$date,$amount)
	{
		if(!isset($this->amount[$user_id][$date]['total'])){
			$this->amount[$user_id][$date]['total'] = 0;
		}
		$this->amount[$user_id][$date]['total']+=$amount;
	}
	/**
	 * @var Controller -  Reference to controller class
	 */
	protected $controller;
	/**
	 * Stores reference to controller class
	 * @param Controller $mainClass 
	 * @return TaxCalc $this
	 */
	public function setController(Controller $mainClass) : TaxCalc
	{
		$this->controller = $mainClass;
		return $this;
	}
	
	/**
	 * amount of transactions for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function number_of_transactions($user_id,$date)
	{
		return $this->controller->getUserData($user_id)[$date]['number_of_transactions'];
	}
	/**
	 * amount for the current transaction in EUR for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function amount_in_euro($user_id,$date) 
	{
		return $this->controller->getUserData($user_id)[$date]['amount_in_euro'];
	}
	/**
	 * total current amount in EUR for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function total_amount_in_EUR($user_id,$date)
	{
		return $this->controller->getUserData($user_id)[$date]['total_amount_in_EUR'];	
	}
	/**
	 * Wrapper around controller currencyConvert method
	 * @param float $amount 
	 * @param string $currency 
	 * @return float
	 */
	public function currencyConvert(float $amount,string $currency, string $conversionTo=null)
	{
		return $this->controller->currencyConvert($amount,$currency,$conversionTo);
	}
	/**
	 * Calculation logic for the comision 
	 * @param array $line 
	 * @return array
	 */
	public abstract function taxes($line);
}