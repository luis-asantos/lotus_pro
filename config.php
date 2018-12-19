<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	$config['dbname'] = 'base';
	$config['host'] = '192.168.180.30\QIHOMOL';
	$config['dbuser'] = 'rm';
	$config['dbpass'] = 'q!35c0l@s';
} else {
	$config['dbname'] = 'base';
	$config['host'] = '192.168.180.30\QIHOMOL';
	$config['dbuser'] = 'rm';
	$config['dbpass'] = 'q!35c0l@s';
}