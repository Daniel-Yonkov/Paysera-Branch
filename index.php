<?php
require_once 'vendor/autoload.php';

use Paysera\Branch\Input;
use Paysera\Branch\Parsers\CLIParser;

$cli = new CLIParser();
$input = Input::data($argv[1],$cli);
