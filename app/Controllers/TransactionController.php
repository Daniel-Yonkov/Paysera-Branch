<?php
namespace Paysera\Branch\Controllers;


use Paysera\Branch\Input;
use Paysera\Branch\Output\Reportable;
use Paysera\Branch\Parsers\Parser;
use Paysera\Branch\Model\User;

class TransactionController extends Controller
{
	protected $output;
        
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
            if(!$this->hasModel($line['user_id'])){
            	$this->setModel($line['user_id'], new User());
            }
            $model = $this->getModel($line['user_id']);
			$result[] = $this->taxCalcs[$line['operation_type']." ".$line['user_type']]->setModel($model)->taxes($line);
		}
		return $this->getOutput()? $this->output->print($result) : $result;
	}
        
	public function setOutput(Reportable $output)
	{
		$this->output = $output;
	}
        
	protected function getOutput()
	{
		return $this->output;
	}
}