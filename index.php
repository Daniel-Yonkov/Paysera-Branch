<?php
require_once 'vendor/autoload.php';

use Paysera\Branch\Input;
use Paysera\Branch\Parsers\CLIParser;

$input = Input::data($argv[1],new CLIParser());
var_dump($input);