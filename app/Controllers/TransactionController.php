<?php
namespace Paysera\Branch\Controllers;


use Paysera\Branch\Converters\Converter;
use Paysera\Branch\Input;
use Paysera\Branch\Parsers\Parser;
use Paysera\Branch\Taxes\TaxCalc;

class TransactionController implements Controller
{
	protected $usersData = array();
	protected $taxCalcs = array();
	public function __constrcuct(bool $defaultTaxCalcualtions=true)
	{
		if($defaultTaxCalcualtions){
			$this->addTaxCalculation('cash_out natural',new DefaultCashOut());
			$this->addTaxCalculation('cash_out legal',new LegalCashOut());
			$this->addTaxCalculation('cash_in natural',new DefaultCashIn());
		}
	}
	/**
	 * Add tax calculation object
	 * Throws notices if the key is already defined, use changeTextCalculation instead.
	 * @param string $name - defines the by which the object will be accessed based on the provided data
	 * @param TaxCalc $object 
	 * @return VOID
	 */
	public function addTaxCalculation(string $name, TaxCalc $object) : VOID
	{
		if(key_exists($name, $this->taxCalcs)) trigger_error("Calculation strategy already exists!".$name);
		$this->taxCalcs[$name] = $object->mainReference($this);
	}
	/**
	 * Add tax calculation object, overwrites if the key already exists without notice.
	 * @param string $name - defines the by which the object will be accessed based on the provided data
	 * @param TaxCalc $object 
	 * @return VOID
	 */
	public function changeTextCalculation(string $name, TaxCalc $object) : VOID
	{
		if(!key_exists($name,$this->taxCalcs)) trigger_error("Calculation strategy does not exists!".$name);
		$this->taxCalcs[$name] = $object->mainReference($this);
	}
	/**
	 * Set's the converter for the currency rate calculations
	 * @param Converter $converter 
	 * @return VOID
	 */
	public function setConverter(Converter $converter) : VOID
	{
		$this->currencyConverter = $converter;
	}
	public function currencyConvert(float $amount,string $currency)
	{
		return $this->currencyConverter->convert($amount,$currency);
	}
	/**
	 * Accessor for accessing user stored data for the report (number of transactions,
	 * total, converted amount etc.)
	 * @param int $id 
	 * @return array
	 */
	public function getUserData($id) : array
	{
		return $this->usersData[$id];
	}
	/**
	 * Main method used to generate tax rates based on the provided data
	 * @param mix $data 
	 * @param Parser $parser 
	 * @return array $result
	 */
	public function run($data, Parser $parser)
	{
		$input = Input::data($data,$parser);
		$result = array();
		foreach ($input as $key => $line) {
			$date = yearlyWeek($line['date']);
			if(!isset($this->usersData[$line['user_id']][$date])){
				$this->usersData[$line['user_id']][$date]['number_of_transactions'] = 0;
				$this->usersData[$line['user_id']][$date]['euro_amount'] = 0;
				$this->usersData[$line['user_id']][$date]['total_euro'] = 0;
			}
			if(!isset($this->usersData[$line['user_id']][$date]['total_'.$line['currency']])){
				$this->usersData[$line['user_id']][$date]['total_'.$line['currency']] = 0;
			}
			$this->usersData[$line['user_id']][$date]['number_of_transactions']++;
			$this->usersData[$line['user_id']][$date]['euro_amount'] = $this->currencyConvert($line['amount'],strtoupper($line['currency']));
			// $result[]=$this->taxCalcs[$line['operation_type']." ".$line['user_type']]->taxes($line);
			$this->usersData[$line['user_id']][$date]['total_'.$line['currency']] += $line['amount'];
			$this->usersData[$line['user_id']][$date]['total_euro'] += $this->usersData[$line['user_id']][$date]['euro_amount'];
		}
		return $this->usersData;
	}
}