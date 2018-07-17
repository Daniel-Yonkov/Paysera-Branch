<?php

function yearlyWeek($date){
	return date('o_W',strtotime($date));
}
/**
 * Taken from PHP.net - https://secure.php.net/manual/en/function.ceil.php#50448
 * @param float $value 
 * @param int $places 
 * @return string
 */
function roundUp ($value, $places=2) {
  if ($places < 0) { $places = 0; }
  $mult = pow(10, $places);
  return number_format(ceil($value * $mult) / $mult, 2, '.', '');
}