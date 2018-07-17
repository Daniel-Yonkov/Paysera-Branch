<?php
namespace Paysera\Branch\Controllers;

use Paysera\Branch\Converters\Converter;
use Paysera\Branch\Parsers\Parser;
use Paysera\Branch\Taxes\DefaultCashIn;
use Paysera\Branch\Taxes\DefaultCashOut;
use Paysera\Branch\Taxes\LegalCashOut;
use Paysera\Branch\Taxes\TaxCalc;

abstract class  Controller
{
	protected $taxCalcs = array();
	
	public function __construct(bool $defaultTaxCalcualtions=true)
	{
		if($defaultTaxCalcualtions){
			$this->addTaxCalculation('cash_out natural',new DefaultCashOut());
			$this->addTaxCalculation('cash_out legal',new LegalCashOut());
			$this->addTaxCalculation('cash_in natural',new DefaultCashIn());
			$this->addTaxCalculation('cash_in legal',new DefaultCashIn());
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
		$this->taxCalcs[$name] = $object->setController($this);
	}
	/**
	 * Add tax calculation object, overwrites if the key already exists without notice.
	 * @param string $name - defines the by which the object will be accessed based on the provided data
	 * @param TaxCalc $object 
	 * @return VOID
	 */
	public function changeTaxtCalculation(string $name, TaxCalc $object) : VOID
	{
		if(!key_exists($name,$this->taxCalcs)) trigger_error("Calculation strategy does not exists!".$name);
		$this->taxCalcs[$name] = $object->setController($this);
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
	public function currencyConvert(float $amount,string $currency, string $conversionTo=null)
	{
		return $this->currencyConverter->convert($amount,$currency,$conversionTo);
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
	public abstract function run($data, Parser $parser);
}