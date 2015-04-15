<?php

require 'config/Config.php';

function __autoload($class)
{
	require CORE . $class .'.php';
}

$app = new Bootstrap();