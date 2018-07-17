<?php
namespace Paysera\Branch\Controllers;

use Paysera\Branch\Input;
use Paysera\Branch\Output\Reportable;
use Paysera\Branch\Parsers\Parser;

class TransactionController extends Controller
{
	protected $usersData = array();
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
			if(!isset($this->usersData[$line['user_id']][$date])){
				$this->usersData[$line['user_id']][$date]['number_of_transactions'] = 0;
				$this->usersData[$line['user_id']][$date]['amount_in_euro'] = 0;
			}
			$this->usersData[$line['user_id']][$date]['number_of_transactions']++;
			$this->usersData[$line['user_id']][$date]['amount_in_euro'] = $this->currencyConvert($line['amount'],strtoupper($line['currency']));
			$result[]=$this->taxCalcs[$line['operation_type']." ".$line['user_type']]->taxes($line);
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