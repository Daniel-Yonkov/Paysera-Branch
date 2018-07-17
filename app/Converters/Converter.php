<?php
namespace Paysera\Branch\Converters;

abstract class Converter
{
	protected $currenciesRate = array();
	public function convert($value, string $convertFrom, string $convertTo = "EUR"){
		if($convertFrom === 'EUR') $result = $value;
		elseif($convertTo === 'EUR' && isset($this->currenciesRate[1][$convertFrom])){
			$result = $value/$this->currenciesRate[1][$convertFrom];
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
	public function getRates() : array
	{
		return $this->rates;
	}
}