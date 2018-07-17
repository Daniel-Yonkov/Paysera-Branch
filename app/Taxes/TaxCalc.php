<?php
namespace Paysera\Branch\Taxes;

use Paysera\Branch\Controllers\Controller;
use Paysera\Branch\Model\Model;

/**
 * @method Controller currencyConvert(float $amount,string $currency, string $conversionTo=null)
 */
abstract class TaxCalc
{
        
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
        
        protected function getController() : Controller
	{
		return $this->controller;
	}
        
	/**
	 * @var Model -  Reference to model
	 */
	protected $model;
        
	/**
	 * Stores reference to model class
	 * @param Model $model
	 * @return TaxCalc $this
	 */
	public function setModel(Model $model) : TaxCalc
	{
		$this->model = $model;
		return $this;
	}
        
	/**
	 * Get reference to model class
	 * @return Model
	 */
	protected function getModel() : Model
	{
		return $this->model;
	}
        
        public function __call($method, $args) {
            if(method_exists($this->model,$method)) {
                return $this->getModel()->$method(...$args);
            } else if($method == "currencyConvert") {
                return $this->getController()->$method(...$args);
            } else {
                return 123;
            }
        }
        
	/**
	 * Calculation logic for the comision 
	 * @param array $line 
	 * @return array
	 */
	public abstract function taxes($line);
}