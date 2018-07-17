<?php
namespace Paysera\Branch\Converters;

abstract class Converter
{
	public function __construct()
	{
		//EUR:USD - 1:1.1497, EUR:JPY - 1:129.53
		//Currencly it supports only one rate for the default currency, 
		
		$this->setRates($this->defineCurrencyRates());
		$this->defaultCurrency = $this->defineDefaultCurrency();
	}
	protected $defaultCurrency;
	protected $currenciesRate = array();
	public function convert($value, string $convertFrom, string $convertTo = null){
		//check if conversion is needed (currency is the same as default currency)
		if($convertFrom === $this->defaultCurrency && ($convertTo === $this->defaultCurrency || $convertTo === null)){
			$result = $value;
		}
		//converts supported currency to default currency if it exists
		elseif(($convertTo === null || $convertTo === $this->defaultCurrency) && isset($this->currenciesRate[key($this->currenciesRate)][$convertFrom])){
			$result = 
			($value*key($this->currenciesRate))
			/
			$this->currenciesRate[key($this->currenciesRate)][$convertFrom];
		}
		//conversion from defaut currency to supported one
		elseif(($convertFrom === $this->defaultCurrency && $convertTo !== $this->defaultCurrency) && isset($this->currenciesRate[key($this->currenciesRate)][$convertTo]))
		{
			$result = $value*key($this->currenciesRate)*$this->currenciesRate[key($this->currenciesRate)][$convertTo];
		}
		/** 
		 * Tries to convert Convert From Currency to Convert To Currency
	 	 * trhough tertiary currency, which has rate to the Convert To Currency.
		 * Example: Convert From JPY to USD
		 * EUR:USD = 1.94:1 ; JPY:EUR = 1:125 => 1*125/1,94
		 * ['EUR' => ['USD' = 1.94],
		    'EUR' => ['JPY' = 125]
		   ]
		    = 
	*/
		else{
			foreach ($this->currenciesRate as $mainCurrencyRate => $secondaryCurrency) {
			    foreach($secondaryCurrency as $currency => $rate){
			        if($convertFrom === $currency) {
			            $toMainCurrency = ($value/$rate)*$mainCurrencyRate;
			            foreach ($this->currenciesRate as $second) {
			                foreach($second as $c => $r){
			                    if($convertTo === $c){
			                        $result = $toMainCurrency*$r;
				                }
				            }
				        }
		                if(!isset($result)){
		                    throw new \Exception('Currency not supported');
			            }
			        }
			    }
			}
		}
		return round($result,2);
	}
	
	public function setRates(array $rates): VOID
	{
		$this->currenciesRate = $rates;
	}
	public abstract function defineCurrencyRates();
	public abstract function defineDefaultCurrency();
}