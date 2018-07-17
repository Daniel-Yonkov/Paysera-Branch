<?php
namespace Paysera\Branch\Taxes;
abstract class TaxCalc
{
	/**
	 * @var Controller -  Reference to controller class
	 */
	protected $mainClass = null;
	/**
	 * Stores reference to controller class
	 * @param Controller $mainClass 
	 * @return void
	 */
	public function mainReference(Controller $mainClass) : VOID
	{
		$this->mainReference = $mainClass;
	}
	/**
	 * amount of transactions for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function number_of_transactions($user_id,$date)
	{
		return $this->mainReference->usersData[$user_id][$date]['number_of_transactions'];
	}
	/**
	 * amount for the current transaction in EUR for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function amount_in_euro($user_id,$date) 
	{
		return $this->mainReference->usersData[$user_id][$date]['amount_in_euro'];
	}
	/**
	 * total current amount in EUR for the specific user & date combination
	 * @param int|string $user_id 
	 * @param string $date 
	 * @return int
	 */
	protected function total_euro($user_id,$date)
	{
		return $this->mainReference->usersData[$user_id][$date]['total_euro'];	
	}
	/**
	 * Calculation logic for the comision 
	 * @param array $line 
	 * @return array
	 */
	public abstract function taxes($line);
}