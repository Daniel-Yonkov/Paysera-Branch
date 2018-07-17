<?php

function yearlyWeek($date){
	return date('o_W',strtotime($date));
}